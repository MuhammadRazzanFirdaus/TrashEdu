<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->role == 'admin') {
            //return $next -> melanjutkan proses tampilan halaman
            return $next($request);
        }else {
            //jika belum login dan bukan admin balik ke halaman home
            return redirect()->back()->with('danger', 'Dilarang mengakses halaman admin!');
        };
    }
}
