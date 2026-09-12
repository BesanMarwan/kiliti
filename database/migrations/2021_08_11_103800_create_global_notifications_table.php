<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->text('message')->nullable();
            $table->string('image')->nullable();
            $table->integer('admin_id')->nullable();
//            $table->string('type');

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
        Schema::dropIfExists('global_notifications');
    }

    public function addPermissions()
    {
        $permissions = collect([
            'global_notifications.view',
            'global_notifications.create',
            'global_notifications.edit',
            'global_notifications.delete',
            'global_notifications.activate',
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

        \Illuminate\Support\Facades\DB::transaction(function () use ($tableNames) {
            foreach ($this->permissions as $permission) {
                $permissionItem = \Illuminate\Support\Facades\DB::table($tableNames['permissions'])->where([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ])->first();
                if ($permissionItem === null) {
                    \Illuminate\Support\Facades\DB::table($tableNames['permissions'])->insert($permission);
                }
            }
        });
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
