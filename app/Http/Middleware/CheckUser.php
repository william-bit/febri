<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class CheckUser
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        if (auth()->user()->role_id != 1) {
            return redirect(RouteServiceProvider::HOME);
        }
        return $next($request);
    }
}
?>
