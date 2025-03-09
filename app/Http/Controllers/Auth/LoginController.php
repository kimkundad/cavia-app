<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request)
    {
        $user = Auth::user();

        // ถ้ามี Session เก่าอยู่แล้ว → ให้ทำการ Logout Session เก่า
        if ($user->session_id) {
            Session::getHandler()->destroy($user->session_id);
        }

        // บันทึก session_id ใหม่
        $user->session_id = Session::getId();
        $user->save();

        // ตรวจสอบ role และ redirect ไปยังหน้าที่เหมาะสม
        if ($user->hasRole('superadmin')) {
            return redirect('/admin/dashboard');
        }
        if ($user->hasRole('admin')) {
            return redirect('/admin/dashboard');
        }
        if ($user->hasRole('user')) {
            return redirect('/');
        }

        return redirect('/');
    }

    public function username(){
        return 'name';
    }


    public function logout(Request $request)
    {
        $user = Auth::user();

        // ล้าง session_id ของ user
        if ($user) {
            $user->session_id = null;
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
