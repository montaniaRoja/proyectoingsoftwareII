<div class="container-fluid px-4">
    <h5 class="mt-4">Usuarios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">@include('layouts._partials.messages')</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">

            </div>
        </div>

        <div class="card-body">
            <div style="display: flex; align-items: center;">
                <div class="mb-3" style="margin-right: 20px; width: 70%">
                    <label for="name" style="padding-right: 10px;">Buscar Usuarios</label>
                    <input type="text" wire:model.lazy="search" class="form-control" placeholder="Digite el nombre y presione Enter..." style="width: 90%;">
                </div>
                <div class="mb-3" style="padding-left: 0px; width: 30%">
                    <label for="perPage">Registros por Pagina</label>
                    <select wire:model="perPage" class="form-control" style="width: 100px;" id="perPage">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>

                </div>

            </div>

        </div>
        @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="table-responsive">
            <table class="account-table table" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Autorizado</th>
                        <th>Editar</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email }}</td>
                        <td>{{$user?->role->name ?? 'NA'}}</td>
                        @if($user->authorized==1)
                        <td>True</td>
                        @else
                        <td>False</td>
                        @endif
                        <td>
                            <button type="button" class="btn btn-primary btn-sm"
                                wire:click="edit({{$user->id}})">
                                Editar
                            </button>
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>

                    </div>
                    <div class="modal-body">
                        <form wire:submit="update">
                            <input type="text" name="rol" id="rol" wire:model="userRol">

                            <input type="text" name="userId" id="userId" wire:model="userId">
                            <div class="form-floating mb-3" style="width: 100%;">
                                <input type="text" class="form-control" name="name" id="userName" readonly wire:model="userName">
                                <label for="name">Nombre del Usuario</label>

                            </div>
                            <div class="form-floating mb-3" style="width: 100%;">
                                <input type="mail" class="form-control" name="mail" id="userEmail" wire:model="userEmail">
                                <label for="mail">Correo del Usuario</label>

                            </div>
                            <div class="mb-3" style="width: 100%;">
                                <label for="">Asigne Rol</label>
                                <select class="form-control" name="rolSelect" id="rolSelect">
                                    <option value="">Seleccione un rol</option> <!-- Opción vacía por defecto -->
                                    @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>

                            </div>


                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="authorized" wire:model="authorized">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Autorizar/Desactivar
                                </label>
                            </div>

                            <div class="mb-3 mt-3">
                                <button type="submit" class="btn btn-primary">Guardar</button>
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

        <script src="{{ asset('js/users.js') }}"></script>
</div>
