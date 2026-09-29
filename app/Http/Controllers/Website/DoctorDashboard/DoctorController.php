<?php

namespace App\Http\Controllers\Website\DoctorDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function save_token(Request $request)
    {
        $user= \Auth::guard('user')->user();
//        $user->fcm_token = $request->token;
//        $user->save();
//
        if($user)
            return response()->json([
                'message' => 'User token updated'
            ]);

        return response()->json([
            'message' => 'Error!'
        ]);
    }
}
