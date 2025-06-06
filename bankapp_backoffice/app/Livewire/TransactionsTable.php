<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Balance;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


class TransactionsTable extends DataTableComponent
{
    protected $model = Balance::class;

    public $accountId;

    protected $listeners = ['setAccountFilters' => 'setFiltersManual'];

    public function mount($accountId = null)
    {
        $this->accountId = $accountId;
    }

    public function configure(): void
    {

        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => 'table table-striped table-hover table-bordered',
            ])->setEmptyMessage('No hay transacciones aun');
    }

    public function setTableRowClass($row): ?string
    {
        return $row->movimiento === 'Retiro' ? 'table-danger' : null;
    }


    public function setFiltersManual($accountId)
    {
        $this->accountId = $accountId;
    }

    public function builder(): Builder
    {
        $query = Balance::query()
            ->with(['user'])
            ->select('balances.*');

        return $query;
    }

    public function columns(): array
    {
        return [
            Column::make("Fecha", "fecha"),

            Column::make("Depositos", "monto")
                ->format(fn($value, $row) => number_format($value, 2)),

            Column::make("Retiros", "retiro")
                ->format(fn($value, $row) => number_format($value, 2)),

            Column::make("Saldo", "saldo")
                ->format(fn($value, $row) => number_format($value, 2)),

            Column::make("Usuario", "user.name"),
        ];
    }
}
