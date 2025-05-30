<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Only_Anggota
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->id_role != '3') {
            if (Auth::user()->id_role == '1') {
                return redirect('superadmin/dashboard');
            } else {
                return redirect('admin/dashboard');
            }
        }
        return $next($request);
    }
}
