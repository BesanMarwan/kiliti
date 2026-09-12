<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Invitation;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {

        if(request()->get('mode') == 'dark'){
            session(['mode'=>'dark']);
        }
        if(request()->get('mode') == 'light'){
            session(['mode'=>'light']);
        }
        $counts=[];
        $counts[]=[
            'href'=>'#',
            'title'=>'مثال 1',
            'count'=>50,
            'count_text'=>' مثال',
            'svg'=>'metronic-Equalizer',
            'class'=>'col-md-3',
            'color'=>'danger',
            'permission'=>'orders.view',

        ];
        $counts[]=[
            'href'=>'#',
            'title'=>'مثال 2',
            'count'=>60,
            'count_text'=>' مثال',
            'svg'=>'metronic-Group',
            'class'=>'col-md-3',
            'color'=>'primary',
            'permission'=>'drivers.view',
        ];
        $counts[]=[
            'href'=>'#',
            'title'=>'مثال 3',
            'count'=>20,
            'count_text'=>' مثال',
            'icon'=>'fa fa-star',
            'class'=>'col-md-3',
            'color'=>'success',
            'permission'=>'operators.view',
        ];
        $counts[]=[
            'href'=>'#',
            'title'=>'مثال 4',
            'count'=>13,
            'count_text'=>' مثال',
            'svg'=>'metronic-Trash',
            'class'=>'col-md-3',
            'color'=>'info',
            'permission'=>'companies.view',
        ];


        $data['counts']  =$counts;



        $data['user_count']             = User::count();
        $data['user_enabled']           = User::where('status','enabled')->count();
        $data['user_enabled_percent']   = $data['user_count'] != 0 ? number_format(($data['user_enabled'] / $data['user_count'])*100,2) : 0;
//
//        $data['cat_count']                 = Category::count();
//        $data['cat_enabled']               = Category::active()->count();
//        $data['cat_enabled_percent']       = $data['cat_count'] != 0 ? number_format(($data['cat_enabled'] / $data['cat_count'])*100,2) : 0;
//

        /*
         * Users (Ios and Android) chart
         */
        $users                 = $data['user_count'];
        $users_ios_percent     = $users != 0 ? number_format((User::where('device_type','ios')->count() /$users)*100,2) :0;
        $users_android_percent = $users != 0 ? number_format((User::where('device_type','android')->count() /$users)*100,2) : 0;

        $users_chart =[
            'labels'=>[lng('dashboard.general.users_ios','مستخدمين IOS'),lng('dashboard.general.users_android','مستخدمين Android')],
            'series'=>[$users_ios_percent,$users_android_percent],
            'total'=>$users,
        ];
        $data['users_chart'] =$users_chart;

   /*

        Chart Example
        $ordersPerMonth=[];
        $start=Carbon::now()->startOfMonth()->subMonths(7);
        $end=Carbon::now()->startOfMonth();
        while ($start->lte($end)){
            $ordersPerMonth[$start->monthName]=Order::whereBetween('order_date',[$start->startOfMonth()->toDateTimeString(),$start->endOfMonth()->toDateTimeString()])->count();
            $start->startOfMonth()->addMonth();

        }
*/

        return view('admin.dashboard',$data);

    }



    public function changeLanguage($lang){

        app()->setLocale($lang);
        return redirect()->back();


    }



}
