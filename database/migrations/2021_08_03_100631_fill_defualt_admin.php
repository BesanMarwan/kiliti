<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FillDefualtAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $adminUser = new \App\Models\Admin();

        $adminUser->name = 'Besan';
        $adminUser->email = 'besanmarwan2000@gmail.com';
        $adminUser->mobile = '0597501686';
        $adminUser->fcm_token = '';
        $adminUser->password = \Illuminate\Support\Facades\Hash::make('0597501686');
        $adminUser->save();
        $role = Role::updateOrCreate(['name' => 'Super Admin','guard_name' => 'admin']);
        $adminUser->assignRole($role);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
