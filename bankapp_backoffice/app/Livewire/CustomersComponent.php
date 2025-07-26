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
    public $customerId = '';
    public $noIdentidad = '';
    public $nombreCliente = '';
    public $correo = '';
    public $direccion = '';
    public $telefono = '';


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
            $customers = Customer::where('nombre', 'ilike', '%' . $this->search . '%')
                ->orWhere('no_doc', 'like', '%' . $this->search . '%')
                ->orWhere('correo', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'desc')
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

    public function getCustomerData()
    {
        $this->dispatch('show-customer-modal');
    }

    public function closeModal()
    {
        $this->dispatch('hide-customer-modal');
    }

    public function closeEditModal()
    {
        $this->dispatch('hide-editcustomer-modal');
    }

    public function store()
    {
        try {
            $validatedData = $this->validate([
                'noIdentidad' => 'required',
                'nombreCliente' => 'required',
                'correo' => 'required',
                'direccion' => 'required',
                'telefono' => 'required'

            ]);

            Customer::create([
                'no_doc' => $this->noIdentidad,
                'nombre' =>  $this->nombreCliente,
                'correo' => $this->correo,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'creado_por' => auth()->id(),
            ]);

            session()->flash('success', $this->nombreCliente . ' Cliente agregado exitosamente.');


            return redirect('customers');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('hide-breed-modal');
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Hubo errores al guardar raza.');
            session()->flash('validationErrors', $e->errors());
        }
    }

    public function update() {
         try {
            $validatedData = $this->validate([
                'customerId'=>'required',
                'noIdentidad' => 'required',
                'nombreCliente' => 'required',
                'correo' => 'required',
                'direccion' => 'required',
                'telefono' => 'required'

            ]);

            $cliente = Customer::findOrFail($this->customerId);

            $cliente->update([
                'no_doc'=>$this->noIdentidad,
                'nombre'=>$this->nombreCliente,
                'correo'=>$this->correo,
                'direccion'=>$this->direccion,
                'telefono'=>$this->telefono
            ]);

            session()->flash('success', $this->nombreCliente . ' Cliente actualizado exitosamente.');


            return redirect('customers');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('hide-breed-modal');
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Hubo errores al guardar raza.');
            session()->flash('validationErrors', $e->errors());
        }
    }

    public function openCustomerEditWindow($clienteId)
    {

        $cliente = Customer::findOrFail($clienteId);

        $this->customerId = $cliente->id;
        $this->noIdentidad = $cliente->no_doc;
        $this->nombreCliente = $cliente->nombre;
        $this->correo = $cliente->correo;
        $this->direccion = $cliente->direccion;
        $this->telefono = $cliente->telefono;



        $this->dispatch('show-editcustomer-modal');
    }
}
