<div class="container-fluid px-4">
    <h5 class="mt-4">Cuentas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">@include('layouts._partials.messages')</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                @can('crear cuentas')
                <button type="button" class="btn btn-primary" wire:click="openAccountModal">
                    Nueva Cuenta
                </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3" style="padding-left: 0px; width: 30%">
                <label for="perPage">Registros por Pagina</label>
                <select wire:model="perPage" class="form-control" style="width: 100px;" id="perPage">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>

            </div>
            <div class="table-responsive">
                <table class="account-table table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id Cuenta</th>
                            <th>Nombre</th>
                            <th>No Cuenta</th>
                            <th>Moneda</th>
                            <th>Saldo</th>
                            <th>Nueva Transaccion</th>
                            <th>Historial</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($accounts as $account)
                        <tr>
                            <td>{{$account->id}}</td>
                            <td>{{$account->customer->nombre}}</td>
                            <td>{{$account->no_cuenta}}</td>
                            <td>{{$account->moneda}}</td>
                            <td>{{$account->saldo}}</td>
                            <td><button class="btn btn-primary btn-sm" wire:click="newTransaction({{$account->id}})">Registrar</button></td>
                            <td><button class="btn btn-secondary btn-sm" wire:click="showTransactions({{$account->id}})">Historial</button></td>

                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $accounts->links() }}
                </div>

            </div>
            <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar Cuenta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="custom-form profile-form" wire:submit="createAccount">
                                <input class="form-control" type="text" name="customerId" id="customerId" wire:model="customerId" style="display: none;">

                                <input class="form-control" type="text" name="cuenta" id="cuenta" wire:model="noCuenta" placeholder="Numero de Cuenta" disabled>

                                <select class="form-control" id="selectorMoneda" aria-label="Default select example">
                                    <option value="" selected>Selecione Moneda</option>
                                    <option value="Lempiras">Lempiras</option>
                                    <option value="Dolar">Dolares</option>
                                    <option value="Euros">Euros</option>
                                </select>

                                <input class="form-control" type="text" name="moneda" id="moneda" wire:model="moneda" style="display: none;">

                                <div class="d-flex">
                                    <button type="submit" class="form-control me-3" style="background-color:cornflowerblue; color:black;">
                                        Crear Cuenta
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

            <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar Transaccion</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeTransactionModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="custom-form profile-form" wire:submit="createTransaction">
                                <input class="form-control" type="text" name="accountId" id="accountId" wire:model="accountId" style="display: none;">

                                <input class="form-control" type="text" name="cuentaT" id="cuentaT" wire:model="noCuenta" placeholder="Numero de Cuenta" style="display: none;">
                                <p>Cuenta Numero {{$noCuenta}}</p>
                                <select class="form-control" id="selectorTransaccion" aria-label="Default select example">
                                    <option value="" selected>Tipo de Transaccion</option>
                                    <option value="Deposito">Deposito</option>
                                    <option value="Retiro">Retiro</option>

                                </select>

                                <input class="form-control" type="text" name="transaccion" id="transaccion" wire:model="transaccion" style="display: none;">
                                <input class="form-control" type="text" name="saldo" id="saldo" wire:model="saldo" style="display: none;">

                                <input class="form-control" type="number" name="monto" id="monto" wire:model="monto" step="0.01" min="0" placeholder="Monto Transaccion">

                                <div class="d-flex">
                                    <button type="submit" class="form-control me-3" style="background-color:cornflowerblue; color:black;">
                                        Registrar Transaccion
                                    </button>

                                    <button type="button" class="form-control ms-2" data-dismiss="modal" wire:click="closeTransactionModal">
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

            <div class="modal fade" id="transactionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Historial de Cuenta {{$noCuenta}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeTransactionsModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <livewire:transactions-table />

                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <script src="{{ asset('js/accounts.js') }}"></script>
