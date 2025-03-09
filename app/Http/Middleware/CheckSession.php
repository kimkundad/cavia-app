<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // ถ้า session_id ในฐานข้อมูลไม่ตรงกับ session ปัจจุบัน → บังคับ Logout
            if ($user->session_id !== Session::getId()) {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'session' => 'บัญชีของคุณถูกเข้าสู่ระบบจากที่อื่น',
                ]);
            }
        }

        return $next($request);
    }
}
