<?php

namespace App\Http\Controllers;

use App\Console\Commands\EnsureQueueListenerIsRunning;
use App\Jobs\SendAdminNotification;
use App\Models\Category;
use App\Models\Page;
use App\Rules\MinDate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ClosureController extends Controller
{
    public function test()
    {
        SendAdminNotification::dispatch(1,'test_notification',['order_id'=>1,'key2'=>3]);
    }
    public function migrate()
    {
        Artisan::call('migrate');
    }
    public function generate_models()
    {
        $base=base_path();
        print `php $base/artisan ide-helper:models -R -W`;

    }
    public function generate_docs()
    {
        $base=base_path();
        print `php $base/artisan l5-swagger:generate`;

    }

    public function restart_queue()
    {

        $base=base_path();
        $PID=EnsureQueueListenerIsRunning::getPID();
        print `kill -9 $PID`;
        print `php $base/ artisan queue:restart`;

//        Artisan::call('ide-helper:models -R -W');
//        Artisan::call('ide-helper:meta');
    }

    public function clearView()
    {

//        print `php /home/nugjzyiw/public_html/baseProject/artisan config:clear  -n -q`;
        $base=base_path();


        print `php $base/artisan clear-compiled`;
        echo "<br>";
        print `php $base/artisan clear`;
        echo "<br>";
        print `php $base/artisan view:clear`;
        echo "<br>";
        print `php $base/artisan route:clear`;
        echo "<br>";
        print `php $base/artisan config:cache`;
        echo "<br>";
        print `php $base/artisan optimize`;
    }
    public function changeKey()
    {
        $base=base_path();
        print `php $base/artisan key:generate -n -q`;
        print `php $base/artisan config:cache  -n -q`;

    }

    public function ChangeToProduction()
    {
        $base=base_path();
        print `php $base/artisan clear-compiled `;
        echo "<br>";
        print `php $base/artisan env:set APP_ENV=production `;
        echo "<br>";
        print `php $base/artisan env:set APP_DEBUG=false`;
        echo "<br>";
        print `php $base/artisan optimize`;
        echo "<br>";
        print `php $base/artisan view:cache`;
        echo "<br>";
        print `php $base/artisan event:cache`;
        echo "<br>";

    }
    public function ChangeToDevelopment()
    {
        $base=base_path();

        print `php $base/artisan clear-compiled `;
        echo "<br>";
        print `php $base/artisan env:set APP_ENV=local`;
        echo "<br>";
        print `php $base/artisan env:set APP_DEBUG=true`;
        echo "<br>";
        print `php $base/artisan optimize:clear`;
        echo "<br>";
        print `php $base/artisan event:clear`;
        echo "<br>";
        print `php $base/artisan config:cache`;
        echo "<br>";




    }
    public function KillPrcc()
    {
        //    print `ps -A`;
//    print `kill -9 28625`;
    }


    public function down()
    {
        echo 'API DOWN';
        die();
    }


}
