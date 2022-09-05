<?php

namespace App\Http\Controllers\auth;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginAdminRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginUserController extends Controller
{
    public function index()
    {
        return view('auth.user.login');
    }

    public function subLogin(LoginAdminRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_me') ? true : false;
        
        if (Auth::attempt($credentials, $remember)) {
            $infoAccount = Auth::user();

            if($remember){
                Cookie::queue('adminmail', $credentials['email'], 3600);
                Cookie::queue('adminpwd', $credentials['password'], 3600);

                if($infoAccount->role == UserRole::TOURIST && $infoAccount->email_verified_at != null && $infoAccount->status == 1){
                    return redirect('/');
                }else{
                    $this->logout();
                    return redirect()->back()->with('error', 'Your account has not been activated or permission denied');
                }
               
            }else{

                Cookie::queue('adminmail', $credentials['email'], -3600);
                Cookie::queue('adminpwd', $credentials['password'], -3600);
                
                if($infoAccount->role == UserRole::TOURIST && $infoAccount->email_verified_at != null && $infoAccount->status == 1){
                    return redirect('/');
                }else{
                    $this->logout();
                    return redirect()->back()->with('error', 'Your account has not been activated or permission denied');
                }
            }
        }else{
            return redirect()->back()->with('error', 'These credentials do not match our records.')->withInput();
        }
    }

    public function loginUsingGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();

            $saveUser = User::updateOrCreate([
                'google_id' => $user->getId(),
            ],[
                'google_id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'role' => UserRole::TOURIST,
                'password' => Hash::make($user->getName().'@'.$user->getId()),
                'status' => UserStatus::ENABLED,
                'email_verified_at' => now() 
            ]);

            Auth::login($saveUser);

            return redirect('/');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}

?>