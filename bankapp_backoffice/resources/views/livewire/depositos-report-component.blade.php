<div class="container-fluid px-4">
    <h5 class="mt-4">Saldos Clientes</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">@include('layouts._partials.messages')</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <button type="button" class="btn btn-primary" wire:click="exportToExcel">
                    Excel
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

        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Identificacion</th>
                        <th>Cuenta</th>
                        <th>Saldo</th>
                        <th>Moneda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->nombre }}</td>
                        <td>{{ $customer?->no_doc ?? 'NA' }}</td>
                        <td>{{ $customer?->no_cuenta ?? 'NA' }}</td>
                        <td>{{ number_format($customer?->saldo, 2) ?? 'NA' }}</td>
                        <td>{{ $customer?->moneda ?? 'NA' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay datos</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total en Lempiras:</th>
                        <th>{{ number_format($totalLempiras, 2) }}</th>
                        <th>Lempiras</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Total en Dólares:</th>
                        <th>{{ number_format($totalDolares, 2) }}</th>
                        <th>Dolar</th>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-3">
                {{ $customers->links() }}
            </div>
        </div>


</div>
