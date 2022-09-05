<?php

namespace App\Http\Controllers\auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('auth.change-password');
    }

    public function submitChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed', 
            'password_confirmation' => 'required'
        ]);
        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withInput()->with('cpw', 'Incorrect current password');
        }

        if($user->role == UserRole::TOURIST) {
            $url = url('/login');
        }else {
            $url = route('auth.login');
        }

        User::where('email', $user->email)->update(['password' => Hash::make($request->password)]);
        session()->flush();
        auth()->logout();
        return redirect($url)->withInput()->with('message', 'Your password has been changed. Please log in again');
    }
}
