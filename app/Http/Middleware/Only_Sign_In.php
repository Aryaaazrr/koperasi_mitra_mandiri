<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Only_Sign_In
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            if (Auth::user()->id_role == '1') {
                return redirect('superadmin/dashboard');
            }
            if (Auth::user()->id_role == '2') {
                return redirect('admin/dashboard');
            }
            if (Auth::user()->id_role == '3') {
                return redirect('dashboard');
            }
        }
        return $next($request);
    }
}
