<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

       // create permissions
        Permission::create(['name' => 'admin']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'user']);
       
    }
}
