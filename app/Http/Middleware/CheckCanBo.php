<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\LoginController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCanBo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $malop=$request->malop;
        $mamon=$request->mamonhoc;
        $mahocsinh=$request->mahocsinh;
        // dd($mahocsinh);
        $check = LoginController::checkLoginCanBo($malop, $mamon,$mahocsinh);
        if($check) {
            return $next($request);
        }else{
            abort(403);
        }
    }
}
