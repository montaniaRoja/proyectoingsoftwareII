<div class="container-fluid px-4">
    <h5 class="mt-4">Clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">@include('layouts._partials.messages')</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">

                <button type="button" class="btn btn-primary" wire:click="createCustomer">
                    Agregar Nuevo
                </button>
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

        <table id="" class="account-table table" style="width:100%">
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
                    <td>{{$customer?->creado_por}}</td>
                    <td>{{$customer?->created_at}}</td>

                    <td>
                        <button type="button" class="btn btn-primary btn-sm">
                            Ir a Cuentas
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary btn-sm">
                            Editar
                        </button>
                    </td>


                </tr>
                @empty

                @endforelse
            </tbody>
        </table>
        <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="closeModal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

</div>

<script src="{{ asset('js/customers.js') }}"></script>
