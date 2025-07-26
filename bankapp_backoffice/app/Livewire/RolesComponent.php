<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;

class RolesComponent extends Component
{

    public $rolId = '';
    public $name = '';
    public $permissions = [];
    public $permissionsArray = [];
    public $grantedPermissionsArray = [];
    public $isGranted = '';


    public function render()
    {
        $roles = Role::all();

        return view('livewire.roles-component', compact('roles'));
    }

     public function createRol()
    {
        $this->reset(['rolId', 'name', 'permissions', 'permissionsArray', 'grantedPermissionsArray']);

        $permissions = DB::table('permissions')
            ->select('permissions.id AS id', 'permissions.name')
            ->selectRaw('0 AS is_granted')
            ->get();

        $this->permissionsArray = json_encode($permissions);
        $this->permissions = $permissions;
        $this->dispatch('show-rol-modal');
    }

      public function cancelUserEdit()
    {
        $this->dispatch('hide-rol-modal');
    }

     public function editRol($id)
    {
        $this->reset(['rolId', 'name', 'permissions', 'permissionsArray', 'grantedPermissionsArray']);

        $rol = Role::where('id', $id)->first();

        $grantedPermissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', '=', $id)
            ->select('role_has_permissions.permission_id as grantedPermissionId')
            ->get();

        $permissions = DB::table('permissions')
            ->leftJoin('role_has_permissions', function ($join) use ($id) {
                $join->on('permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where('role_has_permissions.role_id', '=', $id);
            })
            ->select('permissions.id', 'permissions.name')
            ->selectRaw('CASE WHEN role_has_permissions.permission_id IS NOT NULL THEN 1 ELSE 0 END AS is_granted')
            ->get();

        $this->permissionsArray = json_encode($permissions);
        $this->grantedPermissionsArray = json_encode($grantedPermissions);
        $this->rolId = $id;
        $this->name = $rol->name;

        $this->dispatch('show-edit-modal');
    }

    public function store()
    {
        try {
            $validatedData = $this->validate([
                'name' => 'required',
                'grantedPermissionsArray' => 'required|json'
            ]);

            $role = Role::create([
                'name' => $this->name,
                'guard_name' => "web",
                'created_by' => auth()->id()

            ]);

            $permisos = json_decode($this->grantedPermissionsArray, true);


            $role->syncPermissions(array_column($permisos, 'grantedPermissionId'));


            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            \Spatie\Permission\Models\Permission::get();

            session()->flash('success', ' Rol creada exitosamente.');
            return redirect('roles');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Hubo errores al crear el rol.');
            session()->flash('validationErrors', $e->errors());
            return back()->withInput();
        } catch (\Exception $e) {
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Ocurrió un error inesperado: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function update()
    {
        try {
            $validatedData = $this->validate([
                'rolId' => 'required',
                'name' => 'required',
                'grantedPermissionsArray' => 'required|json'
            ]);

            DB::table('roles')
                ->where('id', $this->rolId)
                ->update([
                    'name' => $this->name,
                    'guard_name' => "web",

                ]);

            $permisos = json_decode($this->grantedPermissionsArray, true);

            DB::transaction(function () use ($permisos) {

                DB::table('role_has_permissions')
                    ->where('role_id', $this->rolId)
                    ->delete();

                foreach ($permisos as $permiso) {
                    DB::table('role_has_permissions')->insert([
                        'role_id' => $this->rolId,
                        'permission_id' => $permiso['grantedPermissionId']
                    ]);
                }
            });

            app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            \Spatie\Permission\Models\Permission::get();
            session()->flash('success', ' Rol actualizado exitosamente.');
            return redirect('roles');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Hubo errores al crear el rol.');
            session()->flash('validationErrors', $e->errors());
            return back()->withInput();
        } catch (\Exception $e) {
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Ocurrió un error inesperado: ' . $e->getMessage());
            return back()->withInput();
        }
    }



}
