<?php

namespace Shahnewaz\CodeCanyonLicensor\Http\Middleware;

use Route;
use Storage;
use Closure;
use Licensor;

class License
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $config = 'license')
    {
        $verifyPurchase = Licensor::verifyPurchase($config);
        
        
        if (!$verifyPurchase) {
            return redirect()->route('licensor.verify-purchase', $config);
        }

        Licensor::verifyLicense($config);

        return $next($request);
    }

}
