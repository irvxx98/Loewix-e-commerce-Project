<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\Role; // <-- Import Enum Role

class IsDealer
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role === Role::DEALER) {
            return $next($request);
        }

        abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
    }
}
