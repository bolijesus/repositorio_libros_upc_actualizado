<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class ResetPointsDownload
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
        $response = $next($request);
        if (\Auth::user()) {
            $ayer = \Auth::user()->updated_at->day;
            $hoy = Carbon::now()->day;
            if (($hoy>$ayer)) {
            
                $usuario = \Auth::user();
                if ($usuario->puntos_descarga <5) {
                    $usuario->puntos_descarga = 5;      
                    $usuario->save();
                }
                
            }
        }
        
        
        return $response;
    }

    
}
