<?php

namespace App\Http\Middleware;

use App\Enums\AffiliatorStatus;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;

class RequestPayment
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
        if(auth()->check()){
            if(auth()->user()->is_affiliator == AffiliatorStatus::YES && auth()->user()->role == UserRole::TOURIST){
                return $next($request);
            }
            return redirect('/');
        }
        return redirect('/');
    }
}
