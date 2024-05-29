<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_staff = Role::create(['name' => 'staff']);

        $permission_create_role = Permission::create(['name' => 'create_role']);
        $permission_read_role = Permission::create(['name' => 'read_role']);
        $permission_update_role = Permission::create(['name' => 'update_role']);
        $permission_delete_role = Permission::create(['name' => 'delete_role']);

        $permission_create_user = Permission::create(['name' => 'create_user']);
        $permission_read_user = Permission::create(['name' => 'read_user']);
        $permission_update_user = Permission::create(['name' => 'update_user']);
        $permission_delete_user = Permission::create(['name' => 'delete_user']);

        $permissions_admin = [
            $permission_create_role,
            $permission_read_role,
            $permission_update_role,
            $permission_delete_role,
            $permission_create_user,
            $permission_read_user,
            $permission_update_user,
            $permission_delete_user
        ];

        $permissions_staff = [
            $permission_create_user,
            $permission_read_user,
            $permission_update_user
        ];

        $role_admin->syncPermissions($permissions_admin);
        $role_staff->syncPermissions($permissions_staff);
    }
}
