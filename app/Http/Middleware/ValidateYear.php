<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper;

class ValidateYear
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $yearLimit = date("Y");
    	$periode = $request->periode;

        if(!Helper::validateDate($periode, "Y")){
            return redirect()->back()->with("warning", "format tahun tidak valid");
        }

        if($periode > $yearLimit){
            return redirect()->back()->with("warning", "Batas maksimal tahun adalah " . $yearLimit);
        }

        return $next($request);
    }
}
