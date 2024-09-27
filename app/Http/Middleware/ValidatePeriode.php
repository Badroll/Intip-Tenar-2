<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper;

class ValidatePeriode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $dateLimit = date("Y-m", strtotime("-1 months"));
    	$periode = $request->periode;

        if(!Helper::validateDate2($periode, "Y-m")){
            return redirect()->back()->with("warning", "format periode tidak valid");
        }

        if($periode > $dateLimit){
            return redirect()->back()->with("warning", "Batas maksimal periode adalah ". Helper::bulan($dateLimit));
        }
        
        return $next($request);
    }
}
