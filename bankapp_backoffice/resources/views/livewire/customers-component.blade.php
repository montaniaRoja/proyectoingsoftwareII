<div class="container-fluid px-4">
    <h5 class="mt-4">Clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">@include('layouts._partials.messages')</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                @can('crear clientes')
                <button type="button" class="btn btn-primary" wire:click="getCustomerData">
                    Agregar Nuevo
                </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div style="display: flex; align-items: center;">
                <div class="mb-3" style="margin-right: 20px; width: 70%">
                    <label for="name" style="padding-right: 10px;">Buscar Clientes</label>
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
        @php
        use Illuminate\Support\Facades\Crypt;
        @endphp
        <div class="table-responsive">
            <table class="account-table table" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Identidad</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th>Creado por</th>
                        <th>Fecha Creacion</th>
                        <th>Cuentas</th>
                        <th>Editar</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>{{$customer->id}}</td>
                        <td>{{$customer->no_doc}}</td>
                        <td>{{$customer->nombre}}</td>
                        <td>{{$customer?->correo }}</td>
                        <td>{{$customer->telefono}}</td>
                        <td>{{$customer->direccion}}</td>
                        <td>{{$customer?->user->name}}</td>
                        <td>{{$customer?->created_at}}</td>

                        <td>


                            <a class="btn btn-primary btn-sm" href="{{ route('accounts', Crypt::encrypt($customer->id)) }}">
                                Cuentas
                            </a>
                        </td>
                        <td>
                            @can('editar clientes')
                            <button type="button" class="btn btn-secondary btn-sm" wire:click="openCustomerEditWindow({{$customer->id}})">
                                Editar
                            </button>
                            @endcan
                        </td>


                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $customers->links() }}
            </div>
        </div>
        <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="custom-form profile-form" wire:submit="store">

                            <input class="form-control" type="text" name="identidad" id="identidad" wire:model="noIdentidad" placeholder="Numero de Identidad">

                            <input class="form-control" type="text" name="nombre" id="nombre" wire:model="nombreCliente" placeholder="Nombre del Cliente">

                            <input class="form-control" type="email" name="profile-email" id="profile-email" wire:model="correo" placeholder="Johndoe@gmail.com">

                            <input class="form-control" type="text" name="telefono" id="telefono" wire:model="telefono" placeholder="Telefono">

                            <textarea class="form-control" name="direccion" id="direccion" wire:model="direccion" placeholder="Direccion"></textarea>

                            <div class="d-flex">
                                <button type="submit" class="form-control me-3" style="background-color:cornflowerblue; color:black;">
                                    Agregar
                                </button>

                                <button type="button" class="form-control ms-2" data-dismiss="modal" wire:click="closeModal">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="custom-form profile-form" wire:submit="update">
                            <input class="form-control" type="text" name="customerId" id="customerId" wire:model="customerId" value="{{$this->customerId}}">

                            <input class="form-control" type="text" name="identidad" id="identidad" wire:model="noIdentidad" value="{{$this->noIdentidad}}">

                            <input class="form-control" type="text" name="nombre" id="nombre" wire:model="nombreCliente" value="{{$this->nombreCliente}}">

                            <input class="form-control" type="email" name="profile-email" id="profile-email" wire:model="correo" value="{{$this->correo}}">

                            <input class="form-control" type="text" name="telefono" id="telefono" wire:model="telefono" value="{{$this->telefono}}">

                            <input type="text" class="form-control" name="direccion" id="direccion" wire:model="direccion" value="{{$this->direccion}}">

                            <div class="d-flex">
                                <button type="submit" class="form-control me-3" style="background-color:cornflowerblue; color:black;">
                                    Actualizar
                                </button>

                                <button type="button" class="form-control ms-2" data-dismiss="modal" wire:click="closeEditModal">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

</div>

<script src="{{ asset('js/customers.js') }}"></script>
