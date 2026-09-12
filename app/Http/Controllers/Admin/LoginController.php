<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'required', 'password' => 'required']);
        $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];

        if (Auth::guard('admin')->attempt($credentials, true)) {
            $ad=Auth::guard('admin')->user();
            $ad->login_at=Carbon::now();
            $ad->save();
            return redirect()->route('admin.dashboard');
        }else{
            flash('اسم المستخدم او كلمة المرور خاطئة','error');
        }

        return redirect()->back()->withErrors(['email'=>"اسم المستخدم او كلمة المرور خاطئة"])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
