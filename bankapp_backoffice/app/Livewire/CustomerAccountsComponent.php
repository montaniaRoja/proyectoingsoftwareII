<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Account;
use App\Models\Transaccion;
use App\Models\Balance;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Livewire\WithPagination;

class CustomerAccountsComponent extends Component
{
    public $customerId;
    public $perPage = 10;
    public $customer;
    public $noCuenta = '';
    public $moneda = '';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search', 'perPage'];
    public $accountId = '';
    public $transaccion = '';
    public $monto = '';
    public $saldo = '';
    public $transactions = [];
    public $customerName='';


    public function mount($customerId)
    {
        try {
            $id = Crypt::decrypt($customerId);
            $this->customerId = $id;
            $this->customer = Customer::findOrFail($id);
            $this->customerName=$this->customer->nombre;
        } catch (DecryptException $e) {
            abort(404);
        }
    }

    public function render()
    {
        $accounts = Account::where('id_cliente', $this->customerId)
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.customer-accounts-component', [
            'accounts' => $accounts
        ]);
    }

    public function openAccountModal()
    {
        $this->dispatch('show-account-modal');
    }

    public function closeModal()
    {
        $this->reset('noCuenta', 'moneda');
        $this->dispatch('hide-account-modal');
    }

    public function closeTransactionModal()
    {
        $this->reset('noCuenta', 'moneda', 'monto');
        $this->dispatch('hide-transaction-modal');
    }

    public function closeTransactionsModal()
    {

        $this->dispatch('hide-transactions-modal');
    }

    public function createAccount()
    {
        try {

            $validatedData = $this->validate([

                'noCuenta' => 'required',
                'moneda' => 'required'
            ]);

            Account::create([
                'no_cuenta' => $this->noCuenta,
                'id_cliente' =>  $this->customerId,
                'moneda' =>  $this->moneda,
                'creado_por' => auth()->id(),
            ]);

            session()->flash('success', $this->noCuenta . ' Cuenta creada exitosamente.');

            return redirect()->route('accounts', ['customerId' => Crypt::encrypt($this->customerId)]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('hide-account-modal');
            session()->flash('danger', 'Hubo errores al guardar raza.');
            session()->flash('validationErrors', $e->errors());
        }
    }

    public function newTransaction($idCuenta)
    {
        $account = Account::where('id', $idCuenta)->first();

        $this->accountId = $account->id;
        $this->noCuenta = $account->no_cuenta;
        $this->monto = 0;
        $this->saldo = $account->saldo;
        $this->dispatch('show-transaction-modal');
    }

    public function createTransaction()
    {
        try {

            $validatedData = $this->validate([

                'transaccion' => 'required',
                'accountId' => 'required',
                'monto' => 'required',
                'saldo' => 'required'
            ]);

            if ($this->transaccion === "Retiro" && $this->monto > $this->saldo) {
                session()->flash('danger', $this->transaccion . ' monto insuficiente.');
                return redirect()->route('accounts', ['customerId' => Crypt::encrypt($this->customerId)]);
            }

            if ($this->transaccion === "Deposito") {
                Transaccion::create([
                    'cuenta_id' => $this->accountId,
                    'tipo_movimiento' =>  $this->transaccion,
                    'monto' =>  $this->monto,
                    'cajero' => auth()->id(),
                ]);

                Account::where('id', $this->accountId)
                    ->increment('saldo', $this->monto);
            }

            if ($this->transaccion === "Retiro") {
                Transaccion::create([
                    'cuenta_id' => $this->accountId,
                    'tipo_movimiento' =>  $this->transaccion,
                    'monto' =>  $this->monto,
                    'cajero' => auth()->id(),
                ]);

                Account::where('id', $this->accountId)
                    ->decrement('saldo', $this->monto);
            }

            session()->flash('success', $this->transaccion . ' creada exitosamente.');

            return redirect()->route('accounts', ['customerId' => Crypt::encrypt($this->customerId)]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('hide-account-modal');
            session()->flash('danger', 'Hubo errores al guardar raza.');
            session()->flash('validationErrors', $e->errors());
        }
    }

    public function showTransactions($idCuenta)
    {

        Balance::truncate();

        $cuenta=Account::where('id', $idCuenta)->first();

        $balances=Transaccion::where('cuenta_id', $idCuenta)->orderBy('id')->get();

        $saldo=0;
        $montoDeposito=0;
        $montoRetiro=0;

        foreach($balances as $balance){
            if($balance->tipo_movimiento==="Deposito"){
                $saldo+=$balance->monto;
                $montoDeposito=$balance->monto;
                $montoRetiro=0;
            }else{
                $saldo-=$balance->monto;
                $montoDeposito=0;
                $montoRetiro=$balance->monto;
            }
            Balance::create([
               'fecha'=>$balance->created_at,
               'movimiento'=>$balance->tipo_movimiento,
               'monto'=>$montoDeposito,
               'saldo'=>$saldo,
               'user'=>$balance->cajero,
               'retiro'=>$montoRetiro
            ]);
        }

        $this->noCuenta=$cuenta->no_cuenta;
        $this->dispatch('setAccountFilters', $idCuenta);
        $this->dispatch('show-transactions-modal');
    }
}
