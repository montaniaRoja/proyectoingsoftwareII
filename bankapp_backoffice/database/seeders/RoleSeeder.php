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
        $role_admin = Role::create(['name' => 'Admin']);
        $role_cajero = Role::create(['name' => 'Cajero']);
        $role_atencion = Role::create(['name' => 'Atencion']);

        $permission_create_role = Permission::create(['name' => 'create roles']);
        $permission_read_role = Permission::create(['name' => 'read roles']);
        $permission_update_role = Permission::create(['name' => 'update roles']);
        $permission_delete_role = Permission::create(['name' => 'delete roles']);

        $permission_authorize_user = Permission::create(['name' => 'autorizar usuarios']);
        $permission_create_customer = Permission::create(['name' => 'crear clientes']);
        $permission_edit_customer = Permission::create(['name' => 'editar clientes']);
        $permission_create_account = Permission::create(['name' => 'crear cuentas']);
        $permission_make_deposit = Permission::create(['name' => 'hacer depositos']);
        $permission_make_retire = Permission::create(['name' => 'hacer retiros']);

        $permissions_admin = [
            $permission_create_role,
            $permission_read_role,
            $permission_update_role,
            $permission_delete_role,
            $permission_authorize_user,
            $permission_create_customer,
            $permission_edit_customer,
            $permission_create_account,
            $permission_make_deposit,
            $permission_make_retire,
        ];

        $permissions_cajero = [
            $permission_make_deposit,
            $permission_make_retire
        ];

        $permissions_atencion = [
            $permission_create_customer,
            $permission_edit_customer,
            $permission_create_account
        ];

        $role_admin->syncPermissions($permissions_admin);
        $role_cajero->syncPermissions($permissions_cajero);
        $role_atencion->syncPermissions($permissions_atencion);
    }
}
