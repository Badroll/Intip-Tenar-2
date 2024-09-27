<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper;

class VerifyAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = Session("admin_session")->U_ROLE;
        $method = $request->method();
        if($role == "ROLE_USER"){
            if($method == "GET"){
                return redirect()->back()->with("warning", "Anda tidak memiliki hak akses ke menu ini");
            }else if($method == "POST"){
                return Helper::composeReply2("ERROR", "Access denied");
            }
        }

        return $next($request);
    }
}
