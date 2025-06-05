<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Account;
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


    public function mount($customerId)
    {
        try {
            $id = Crypt::decrypt($customerId);
            $this->customerId = $id;
            $this->customer = Customer::findOrFail($id);
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
}
