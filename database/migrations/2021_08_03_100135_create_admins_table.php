<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{

    protected $permissions;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('fcm_token')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });


        $this->addPermissions();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
    public function addPermissions()
    {

        $permissions = collect([
            'admins.view',
            'admins.create',
            'admins.edit',
            'admins.delete',
            'admins.activate',
        ]);
       $this->permissions = $permissions->map(function ($permission) {
           return [
               'name' => $permission,
               'guard_name' => 'admin',
               'created_at' => \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now(),
           ];
       })->toArray();

     $tableNames = config('permission.table_names', [
               'roles' => 'roles',
               'permissions' => 'permissions',
               'model_has_permissions' => 'model_has_permissions',
               'model_has_roles' => 'model_has_roles',
               'role_has_permissions' => 'role_has_permissions',
           ]);

       \Illuminate\Support\Facades\DB::transaction(function () use($tableNames) {
           foreach ($this->permissions as $permission) {
               $permissionItem = \Illuminate\Support\Facades\DB::table($tableNames['permissions'])->where([
                   'name' => $permission['name'],
                   'guard_name' => $permission['guard_name']
               ])->first();
               if ($permissionItem === null) {
                   \Illuminate\Support\Facades\DB::table($tableNames['permissions'])->insert($permission);
               }
           }
       });
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }


}
