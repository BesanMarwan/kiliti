<?php

namespace App\Http\Controllers\Website\DoctorDashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('doctors.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, ['mobile' => 'required', 'password' => 'required']);
        $credentials = ['mobile' => $request->get('mobile'), 'password' => $request->get('password')];

        if (Auth::guard('web')->attempt($credentials, true)) {
            $ad=Auth::guard('web')->user();
            $ad->last_login=Carbon::now();
            $ad->save();
            return redirect()->route('doctors.dashboard');
        }else{
            flash('اسم المستخدم او كلمة المرور خاطئة','error');
        }

        return redirect()->back()->withErrors(['email'=>"اسم المستخدم او كلمة المرور خاطئة"])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
