<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\PaymentDetail;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompaniesComponent extends Component
{

    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $rtn = '';
    public $nombrePago = '';
    public $telefono = '';
    public $companyId = '';
    public $clavecontrato = '';
    public $montocontrato = '';
    public $periodo = '';
    public $suscriptor = '';
    public $nombreEmpresa='';

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
            $companies = Payment::where('nombre_pago', 'ilike', '%' . $this->search . '%')
                ->orWhere('rtn', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'desc')
                ->paginate($this->perPage);
            //->withQueryString()

        } catch (\Exception $e) {
            // Registra el error en los logs de Laravel
            Log::error('Error al cargar empresas: ' . $e->getMessage());

            // Opcional: Puedes agregar una alerta para mostrar en la vista
            session()->flash('error', 'Hubo un problema al cargar las empresas.');

            // Devuelve una colección vacía para evitar que la página se rompa
            $companies = collect();
        }

        return view('livewire.companies-component', ['companies' => $companies]);
    }

    public function getCompanyData()
    {
        $this->dispatch('show-company-modal');
    }

    public function closeCompanyModal()
    {
        $this->dispatch('hide-company-modal');
    }

    public function closePaymentModal()
    {
        $this->dispatch('hide-payment-modal');
    }

    public function closeContratosModal()
    {
        $this->dispatch('hide-contratos-modal');
    }

    public function store()
    {
        try {
            $validatedData = $this->validate([
                'rtn' => 'required',
                'nombrePago' => 'required',
                'telefono' => 'required'

            ]);

            Payment::create([
                'rtn' => $this->rtn,
                'nombre_pago' =>  $this->nombrePago,
                'telefono' => $this->telefono,
                'creado_por' => auth()->id(),
            ]);

            session()->flash('success', $this->nombrePago . ' Empresa agregado exitosamente.');

            return redirect('companies');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('hide-breed-modal');
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Hubo errores al crear la empresa.');
            session()->flash('validationErrors', $e->errors());
        }
    }

    public function addPayment($paymentId)
    {
        $company = DB::table('payments')
            ->where('id', $paymentId)
            ->first();

        $this->companyId = $company->id;
        $this->dispatch('show-payment-modal');
    }

    public function savePayment()
    {

        try {
            $validatedData = $this->validate([
                'clavecontrato' => 'required',
                'montocontrato' => 'required',
                'periodo' => 'required',
                'suscriptor' => 'required'

            ]);
            PaymentDetail::create([
                'id_pago' => $this->companyId,
                'clavepago' => $this->clavecontrato,
                'monto' => $this->montocontrato,
                'periodo' => $this->periodo,
                'suscriptor' => $this->suscriptor,
                'status' => "Pendiente"
            ]);
            session()->flash('success', ' Se agrego un nuevo saldo de contrato a la empresa.');

            return redirect('companies');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('hide-breed-modal');
            $this->dispatch('remove-backdrop');
            session()->flash('danger', 'Hubo errores al crear el pago.');
            session()->flash('validationErrors', $e->errors());
        }
    }

    public function showContratos($companyId){
        $empresa=DB::table('payments')
        ->where('id',$companyId)
        ->first();

        $this->nombreEmpresa=$empresa->nombre_pago;

        $detalles=DB::table('payment_details')
        ->where('id_pago',$companyId)
        ->where('status','Pendiente')
        ->get();

        $this->dispatch('setDetailPaymentsFilter', $companyId);

        $this->dispatch('show-contratos-modal');
    }
}
