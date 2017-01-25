<?php

namespace App\Http\Middleware;

use Closure;

class InvestorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user->status == 'disabled') {
            return redirect('/disabled');
        }
        if($user->isAdmin)
            return redirect('/admin');
        elseif($user->isDriver)
            return redirect('/driver');
        //allow investor type to follow through

        return $next($request);
    }
}
