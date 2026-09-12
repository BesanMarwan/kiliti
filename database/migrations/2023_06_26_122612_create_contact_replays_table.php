<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $permissions;

    public function up()
    {
        Schema::create('contact_replays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            $table->string('message');
            $table->morphs('owner');
            $table->timestamps();
        });
        $this->addPermissions();

    }

 public function addPermissions()
     {

         $permissions = collect([
             'contact_replays.view',
             'contact_replays.create',
             'contact_replays.edit',
             'contact_replays.delete',
             'contact_replays.activate',
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
