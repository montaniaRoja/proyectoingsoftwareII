<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomersComponent extends Component
{

    use WithPagination;
    public $search = '';
    public $perPage = 10;

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
            $customers = Customer::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('no_doc', 'like', '%' . $this->search . '%')
                ->orWhere('correo', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'asc')
                ->paginate($this->perPage);
            //->withQueryString()

        } catch (\Exception $e) {
            // Registra el error en los logs de Laravel
            Log::error('Error al cargar clientes: ' . $e->getMessage());

            // Opcional: Puedes agregar una alerta para mostrar en la vista
            session()->flash('error', 'Hubo un problema al cargar los clientes.');

            // Devuelve una colección vacía para evitar que la página se rompa
            $customers = collect();
        }

        return view('livewire.customers-component', ['customers' => $customers]);
    }

    public function createCustomer(){
        $this->dispatch('show-customer-modal');
    }

    public function closeModal(){
        $this->dispatch('hide-customer-modal');
    }
}
