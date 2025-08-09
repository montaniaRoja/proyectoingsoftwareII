<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;

class DepositosReportComponent extends Component
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
        $customers = DB::table('customers as c')
            ->leftJoin('accounts as a', 'c.id', '=', 'a.id_cliente')
            ->selectRaw('c.nombre, c.no_doc, a.no_cuenta, a.saldo, a.moneda')
            ->where('c.nombre', 'ilike', '%' . $this->search . '%')
            ->paginate($this->perPage);

        // Totales por moneda de la página actual
        $totalLempiras = $customers->where('moneda', 'Lempiras')->sum('saldo');
        $totalDolares = $customers->where('moneda', 'Dolar')->sum('saldo');

        return view('livewire.depositos-report-component', compact('customers', 'totalLempiras', 'totalDolares'));
    }



    public function exportToExcel()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }
}
