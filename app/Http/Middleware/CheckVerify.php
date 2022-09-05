<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->email_verified_at != null){
                if(Auth::user()->role == UserRole::ADMIN){
                    return redirect('admin/dashboards');
                }
                if(Auth::user()->role == UserRole::MANAGER){
                    return redirect('manager/dashboards');
                }
                if(Auth::user()->role == UserRole::TOURIST){
                    return redirect('/');
                }
            }
            return $next($request);
        }
        return redirect('auth/login');
    }
}
