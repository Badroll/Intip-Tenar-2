<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper;

class Authlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session = session('admin_session');
        if(!isset($session) || empty($session)){
            return redirect('auth/login')->with('warning', 'Mohon login terlebih dahulu');
        }

        return $next($request);
    }
}
