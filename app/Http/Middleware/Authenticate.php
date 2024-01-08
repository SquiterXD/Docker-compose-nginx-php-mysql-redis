<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if (session('db_name') != 'PROD') {
            $user = auth()->user();
            $enableUser = explode(',', env('ENABLE_DEBUG_USERNAME', ''));
            if ($user && in_array($user->username, $enableUser) ) {
                \Debugbar::enable();
            } else {
                \Debugbar::disable();
            }
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }
}
