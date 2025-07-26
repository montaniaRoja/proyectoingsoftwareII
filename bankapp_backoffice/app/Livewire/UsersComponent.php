<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersComponent extends Component
{

    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $userId = '';
    public $userName = '';
    public $userEmail = '';
    public $userRol = '';
    public $authorized = '';

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function render()
    {

        try {
            $users = User::where('name', 'ilike', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);
            //->withQueryString()

            $roles = Role::all();
        } catch (\Exception $e) {
            // Registra el error en los logs de Laravel
            Log::error('Error al cargar usuarios: ' . $e->getMessage());

            // Opcional: Puedes agregar una alerta para mostrar en la vista
            session()->flash('error', 'Hubo un problema al cargar los usuarios.');

            // Devuelve una colección vacía para evitar que la página se rompa
            $users = collect();
        }

        return view('livewire.users-component', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function update()
    {
        try {
            // Validar los datos
            $validatedData = $this->validate([
                'userId' => 'required',
                'userEmail' => 'required|email',
                'userRol' => 'required',
                'authorized' => 'required',

            ]);

            // Buscar el usuario por su ID
            $user = User::findOrFail($this->userId);

            // Actualizar los datos del usuario
            $user->update([
                'email' => $this->userEmail,
                'rol_id' => $this->userRol,
                'authorized' => $this->authorized,
                'modified_by' => auth()->id(),
            ]);


            // Asignar el nuevo rol
            $newRole = Role::findById($this->userRol, 'web'); // Especifica el guard si usas múltiples

            $user->syncRoles([$newRole]); // syncRoles reemplaza los roles existentes

            // Recargar los permisos del usuario
            $user->load('roles', 'permissions');

            // Mensaje de éxito
            session()->flash('success', 'Usuario actualizado exitosamente.');

            return $this->redirect('users');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Hubo errores al actualizar el usuario.');
            session()->flash('validationErrors', $e->errors());
            return back()->withInput();
        } catch (\Exception $e) {
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Ocurrió un error inesperado: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();

        $this->userRol = $user->rol_id;

        $this->userName = $user->name;
        $this->userEmail = $user->email;
        $this->authorized = $user->authorized;
        $this->userId = $user->id;

        $this->dispatch('show-edit-modal');
    }

    public function cancelUserEdit()
    {
        $this->dispatch('hide-edit-modal');
    }

}
