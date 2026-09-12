<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    protected $permissions;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('activation_code')->nullable();
            $table->string('reset_code')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->enum('status',['not_verified','enabled','disabled'])->default('not_verified');
            $table->enum('role',['patient','doctor','family','center_staff'])->default('patient');

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('code_finished_at')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('cascade');
            $table->string('language')->nullable();

            $table->string('accessToken')->nullable();
            $table->boolean('mobile_changed')->default(false);
            $table->boolean('enable_notification')->default(true);
            $table->enum('schedule_notification_before', ['15', '30', '60'])->default('15');
            $table->string('app_version')->nullable();
            $table->string('device_type')->nullable();
            $table->enum('register_step',['initial','personal','medical_info','dialysis_center_info','doctor_info','family_member_info','finish'])->default('initial');
            $table->boolean('is_register_end')->default(true);
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
        Schema::dropIfExists('users');
    }
    public function addPermissions()
    {

        $permissions = collect([
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.activate',
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
