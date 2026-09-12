<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $permissions;

    public function up()
    {
        Schema::create('general_data', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('uuid')->nullable()->unique();
            $table->integer('parent_id')->index();
            $table->timestamps();
        });
        $this->addPermissions();
    }

 public function addPermissions()
     {

         $permissions = collect([
             'general_data.view',
             'general_data.create',
             'general_data.edit',
             'general_data.delete',
             'general_data.activate',
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
};
