<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedCitizenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        if ($request->user()->isCitizen() && !$request->user()->isVerified()) {
            return redirect()->route('verification.pending')
                ->with('warning', 'Your account is pending verification by the barangay secretary.');
        }

        return $next($request);
    }
}
