<?php

namespace App\Http\Middleware;

use App\Models\FndUser;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        \Debugbar::disable();
        $is_not_authenticated = false;
        // $user = $_SERVER['PHP_AUTH_USER'];
        // $pw = $_SERVER['PHP_AUTH_PW'];
        // $member = FndUser::where('user_name', $user)->first();
        // Auth::loginUsingId($member->id);
        
        // if (!Auth::check()) {
        //     abort(401);
        // }
        return $next($request);
    }
}
