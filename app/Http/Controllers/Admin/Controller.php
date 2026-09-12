<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller as Base;


class Controller extends Base
{

    public function __construct()
    {
        $active='dashboard';
        $currentRoute=\Illuminate\Support\Facades\Route::current()->getName();
        if($currentRoute){
            $ar=explode('.',$currentRoute);
            if(isset($ar[1])){
                $active=$ar[1];
            }
        }

        \View::share('activeLink',$active);
    }
}
