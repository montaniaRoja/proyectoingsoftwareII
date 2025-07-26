<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\Builder;


class DetallesTable extends DataTableComponent
{
    protected $model = PaymentDetail::class;

    public $companyId;

    protected $listeners = ['setDetailPaymentsFilter' => 'setFiltersManual'];

    public function mount($companyId=null)
    {
        $this->companyId = $companyId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => 'table table-striped table-hover table-bordered'
            ]);
    }

    public function setFiltersManual($companyId)
    {
        $this->companyId = $companyId;
    }

     public function builder(): Builder
    {
        $query=PaymentDetail::query()
        ->select('payment_details.*')
        ->where('id_pago',$this->companyId);

        return $query;

    }

    public function columns(): array
    {
        return [
            Column::make("Contrato", "clavepago")
                ->sortable(),
            Column::make("Cliente", "suscriptor")
                ->sortable()->searchable(),
            Column::make("Periodo", "periodo")
                ->sortable(),
                Column::make("Monto a Pagar", "monto")
                ->sortable(),

        ];
    }
}
