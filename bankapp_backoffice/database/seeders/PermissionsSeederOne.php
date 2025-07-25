<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeederOne extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'crear transacciones'
        ];

         foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

         $rolesWithPermissions = [

            ['roles' => ['Admin', 'cajero'],
             'permissions' => ['crear transacciones']],

        ];

        foreach ($rolesWithPermissions as $group) {
            foreach ($group['roles'] as $roleName) {
                $role = Role::where('name', $roleName)->first();

                if (!$role) {
                    continue; // Si el rol no existe, lo saltamos
                }

                $role->givePermissionTo($group['permissions']);
            }
        }





    }
}
