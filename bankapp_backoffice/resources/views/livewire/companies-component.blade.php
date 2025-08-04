<div class="container-fluid px-4">
    <h5 class="mt-4">Empresas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">@include('layouts._partials.messages')</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                @can('crear clientes')
                <button type="button" class="btn btn-primary" wire:click="getCompanyData">
                    Agregar Nueva
                </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div style="display: flex; align-items: center;">
                <div class="mb-3" style="margin-right: 20px; width: 70%">
                    <label for="name" style="padding-right: 10px;">Buscar Empresas</label>
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
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>RTN</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Cuentas</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($companies as $company)
                    <tr>
                        <td>{{$company->id}}</td>
                        <td>{{$company->rtn}}</td>
                        <td>{{$company->nombre_pago}}</td>
                        <td>{{$company?->telefono }}</td>

                        <td>
                            @can('crear cuentas')
                            <button class="btn btn-primary btn-sm" wire:click="addPayment({{$company->id}})">
                                Nuevo Contrato
                            </button>
                            @endcan
                        </td>
                        <td>
                            @can('editar clientes')
                            <button type="button" class="btn btn-secondary btn-sm" wire:click="showContratos({{$company->id}})">
                                Contratos Pendientes
                            </button>
                            @endcan
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $companies->links() }}
            </div>
        </div>
        <div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $companyId ? 'Editar Empresa' : 'Agregar Empresa' }}</h5>

                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="custom-form profile-form" wire:submit="{{ $companyId ? 'update' : 'store' }}">
                            <input class="form-control" type="text" name="companyId" id="companyId" wire:model="companyId" style="display: none;">

                            <input class="form-control" type="text" name="rtn" id="rtn" wire:model="rtn" placeholder="Numero de RTN">

                            <input class="form-control" type="text" name="nombre_pago" id="nombre_pago" wire:model="nombrePago" placeholder="Nombre de Empresa">

                            <input class="form-control" type="text" name="telefono" id="telefono" wire:model="telefono" placeholder="504-0000-0000">


                            <div class="d-flex">
                                <button type="submit" class="form-control me-3" style="background-color:cornflowerblue; color:black;">
                                    {{ $companyId ? 'Actualizar' : 'Agregar' }}
                                </button>

                                <button type="button" class="form-control ms-2" data-dismiss="modal" wire:click="closeCompanyModal">
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

        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Contrato</h5>

                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <form class="custom-form profile-form" wire:submit="savePayment">

                            <input class="form-control" type="text" name="clavecontrato" id="clavecontrato" wire:model="clavecontrato" placeholder="Numero de Contrato">

                            <input class="form-control" type="number" name="montocontrato" id="montocontrato" wire:model="montocontrato" placeholder="Total a pagar">

                            <input class="form-control" type="text" name="periodo" id="periodo" wire:model="periodo" placeholder="Periodo">

                            <input class="form-control" type="text" name="suscriptor" id="suscriptor" wire:model="suscriptor" placeholder="Nombre del Suscriptor">

                            <div class="d-flex">
                                <button type="submit" class="form-control me-3" style="background-color:cornflowerblue; color:black;">
                                    Agregar
                                </button>

                                <button type="button" class="form-control ms-2" data-dismiss="modal" wire:click="closePaymentModal">
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

        <div class="modal fade" id="contratosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Contratos Pendientes</h5>
                        <p class="modal-title" style="font-weight: bold;">{{$nombreEmpresa}}</p>


                    </div>
                    <div class="modal-body">

                        <livewire:detalles-table />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="form-control ms-2" data-dismiss="modal" wire:click="closeContratosModal">
                            Cerrar
                        </button>

                    </div>
                </div>
            </div>
        </div>

</div>

<script src="{{ asset('js/companies.js') }}"></script>
