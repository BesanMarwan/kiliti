<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcmNotificationsTable extends Migration
{
    protected $permissions;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fcm_notifications', function (Blueprint $table) {
            $table->id();
            $table->morphs('owner');  // it can be user or driver or admin
            $table->string('title');
            $table->string('message');
            $table->longText('data');
            $table->foreignId('global_id')->nullable()->constrained('global_notifications')->onDelete('cascade');
            $table->string('notification_key', 150);
            $table->text('firebase_response')->nullable();
            $table->text('link')->nullable();
            $table->text('image')->nullable();
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('fcm_notifications');
    }

    public function addPermissions()
    {
        $permissions = collect([
            'fcm_notifications.view',
            'fcm_notifications.create',
            'fcm_notifications.edit',
            'fcm_notifications.delete',
            'fcm_notifications.activate',
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
