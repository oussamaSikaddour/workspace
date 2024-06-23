<?php

namespace App\Http\Middleware;

use App\Enums\UserableTypesEnum;
use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $generalSetting = GeneralSetting::first();
          if ($generalSetting?->maintenance){
                return redirect()->route('maintenanceMode');
            }
        // If no maintenance mode or user is an admin, proceed with the request
        return $next($request);
    }

}
