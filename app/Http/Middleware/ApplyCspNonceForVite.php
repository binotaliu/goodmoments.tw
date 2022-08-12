<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

final class ApplyCspNonceForVite
{
    public function handle(Request $request, Closure $next): mixed
    {
        Vite::useCspNonce();

        View::share('csp_script_nonce', Vite::cspNonce());

        return $next($request);
    }
}
