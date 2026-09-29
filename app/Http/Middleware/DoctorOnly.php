<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('doctor.login');
        }

        if (auth()->user()->role != 'doctor') {
            abort(403, 'غير مسموح لك بالوصول إلى هذه الصفحة.');
        }

        return $next($request);
    }
}
