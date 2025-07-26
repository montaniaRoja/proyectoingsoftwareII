<div>
    <div class="container-fluid px-4">
        <h5 class="mt-4">Roles de Usuarios</h5>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">@include('layouts._partials.messages')</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">

                <button type="button" class="btn btn-primary" wire:click="createRol">
                    Nuevo Rol
                </button>
            </div>
            <div class="card-body">
                <table id="mainTable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $rol)
                        <tr>
                            <td>{{$rol->id}}</td>
                            <td>{{$rol->name}}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click="editRol({{$rol->id}})">
                                    Editar
                                </button>
                            </td>

                        </tr>
                        @empty

                        @endforelse

                    </tbody>
                </table>

                <!-- Modal Editar-->
                <div class="modal fade" id="rolModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $rolId ? 'Editar Rol' : 'Nuevo Rol' }}</h5>

                            </div>
                            <div class="modal-body">
                                <form wire:submit="{{ $rolId ? 'update' : 'store' }}">
                                    <input type="number" name="rolId" id="rolId" wire:model="rolId" style="display: none;">
                                    <input type="text" name="permissions" id="permissions" wire:model="permissionsArray" style="display: none;">
                                    <input type="text" name="grantedPermissions" id="grantedPermissions" wire:model="grantedPermissionsArray" style="display: none;">
                                    <div class="form-floating mb-3" style="width: 100%;">
                                        <input type="text" class="form-control" name="rolName" id="rolName" wire:model="name">
                                        <label for="name">Nombre del Rol</label>
                                    </div>

                                    <table id="grantedRolesTbl" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Permiso</th>
                                                <th>Otorgado ?</th>
                                            </tr>
                                        </thead>
                                        <tbody id="permissionsList">

                                        </tbody>

                                    </table>


                                    <div class="mb-3 mt-3">
                                        <button type="submit" class="btn btn-primary">{{ $rolId ? 'Actualizar' : 'Crear' }}</button>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="cancelUserEdit">
                                    Close
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script src="{{ asset('js/userroles.js') }}"></script>
