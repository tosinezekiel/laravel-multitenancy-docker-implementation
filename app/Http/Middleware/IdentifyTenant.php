<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $subdomain = explode('.', $request->getHost())[0];
        $tenant = Tenant::where('domain', $subdomain)->first();
    
        if (!$tenant) {
            abort(404); 
        }
    
        session(['tenant_id' => $tenant->id]);
    
        return $next($request);
    }
}
