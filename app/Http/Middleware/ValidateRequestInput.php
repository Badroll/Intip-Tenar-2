<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Helper;

class ValidateRequestInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Daftar pola yang tidak diizinkan (berpotensi berbahaya)
        $forbiddenPatterns = [
            '/<script\b[^>]*>(.*?)<\/script>/is',  // Tag script
            '/<\?php\b/',                         // Tag PHP
            '/<\?/',                              // Short open tag PHP
        ];

        $forbiddenPatterns2 = [
            '<script>',
            '</script>',
            '<?php',
            '?>'
        ];

        // Iterasi setiap parameter di request
        foreach ($request->all() as $key => $value) {
            // Pastikan hanya parameter string yang diperiksa
            if (is_string($value) && $this->containsForbiddenPatterns2($value, $forbiddenPatterns2)) {
                return Helper::composeReply2("ERROR", "Inputan tidak valid, penyisipan script terdeteksi");
                //return redirect()->back()->with('warning', 'Inputan tidak valid, penyisipan script terdeteksi');
            }
        }

        return $next($request);
    }

    /**
     * Memeriksa apakah string mengandung pola yang tidak diizinkan.
     *
     * @param string $value
     * @param array $forbiddenPatterns
     * @return bool
     */
    private function containsForbiddenPatterns($value, $forbiddenPatterns)
    {
        foreach ($forbiddenPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }
        return false;
    }

    private function containsForbiddenPatterns2($value, $forbiddenPatterns)
    {
        $input = strtolower($value);
        foreach ($forbiddenPatterns as $pattern) {
            $hasSpace = true;
            while ($hasSpace){
                if(str_contains($input, " ")){
                    $input = str_replace(" ", "", $input);
                }
                else{
                    $hasSpace = false;
                }
            }
            if(str_contains($input, $pattern)){
                return true;
            }
        }
        return false;
    }
}
