<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\LoginController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPhuHuynh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $mahocsinh=$request->mahocsinh;
        $malop=$request->malop;
        $check = LoginController::checkLoginPhuHuynh($mahocsinh, $malop);
        if($check) {
            return $next($request);
        }else{
            abort(403);
        }
    }
}
