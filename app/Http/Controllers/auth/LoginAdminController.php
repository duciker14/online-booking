<?php

namespace App\Http\Controllers\auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginAdminRequest;
use App\Mail\VerifyAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class LoginAdminController extends Controller
{
    public function index()
    {
        return view('auth.admin.login');
    }

    public function subLogin(LoginAdminRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_me') ? true : false;
        $code = substr(number_format(time() * rand(),0,'',''),0,6);
        
        if (Auth::attempt($credentials, $remember)) {
            $infoAccount = Auth::user();
            $code = substr(number_format(time() * rand(),0,'',''),0,6);

            if($remember){
                Cookie::queue('adminmail', $credentials['email'], 3600);
                Cookie::queue('adminpwd', $credentials['password'], 3600);

                if($infoAccount->role == UserRole::ADMIN || $infoAccount->role == UserRole::MANAGER){
                    $infoAccount->verify_code()->updateOrCreate(
                        ['user_id' => $infoAccount->id],
                        ['code' => $code, 'email' => $infoAccount->email]
                    );
                    if($infoAccount->email_verified_at == null){
                        Mail::to($infoAccount->email)->send(new VerifyAdmin($infoAccount->verify_code->code));
                        return redirect()->route('auth.verify-admin');
                    }
                    if($infoAccount->role == UserRole::ADMIN){
                        return redirect()->route('admin.dashboards.index');
                    }
                    return redirect()->route('manager.dashboards.index'); 

                }else{
                    return redirect()->back()->with('error', 'These credentials do not match our records.')->withInput();
                }

            }else{

                Cookie::queue('adminmail', $credentials['email'], -3600);
                Cookie::queue('adminpwd', $credentials['password'], -3600);
                
                if($infoAccount->role == UserRole::ADMIN || $infoAccount->role == UserRole::MANAGER){
                    $infoAccount->verify_code()->updateOrCreate(
                        ['user_id' => $infoAccount->id],
                        ['code' => $code, 'email' => $infoAccount->email]
                    );
                    if($infoAccount->email_verified_at == null){
                        Mail::to($infoAccount->email)->send(new VerifyAdmin($infoAccount->verify_code->code));
                        return redirect()->route('auth.verify-admin');
                    }
                    if($infoAccount->role == UserRole::ADMIN){
                        return redirect()->route('admin.dashboards.index');
                    }
                    return redirect()->route('manager.dashboards.index'); 

                }else{
                    return redirect()->back()->with('error', 'These credentials do not match our records.')->withInput();
                }
            }
        }else{
            return redirect()->back()->with('error', 'These credentials do not match our records.')->withInput();
        }
    }

    public function viewVerifyAdmin()
    {
        return view('auth.admin.form_press_code');
    }

    public function verify_admin(Request $request)
    {
        $infoAccount = Auth::user();
        $code = $request->verification_code;
        
        if($infoAccount->verify_code->code == $code){
            $infoAccount->email_verified_at = date('Y-m-d H:i:s');
            $infoAccount->save();
            if($infoAccount->role == UserRole::ADMIN){
                return redirect()->route('admin.dashboards.index');
            }
            return redirect()->route('manager.dashboards.index');
        }else{
            return redirect()->back()->with('error', 'Code is not correct');
        }
    }

    public function logout()
    {
        if(Auth::check()){
            if(Auth::user()->roles == UserRole::ADMIN){
                $infoAccount = Auth::user();
                if($infoAccount->email_verified_at != null){
                    $infoAccount->email_verified_at = null;
                    $infoAccount->save();
                }
            }
            
        }
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}

?>