<?php

namespace App\Exports;

use App\Models\Customer;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('customers as c')
            ->leftJoin('accounts as a', 'c.id', '=', 'a.id_cliente')
            ->select('c.nombre', 'c.no_doc', 'a.no_cuenta', 'a.saldo', 'a.moneda')
            ->where('c.nombre', 'ilike', '%' . request()->search . '%') // si quieres filtrar como en render()
            ->get();
    }

     public function headings(): array
    {
        return ['Nombre', 'Documento', 'No Cuenta', 'Saldo', 'Moneda'];
    }
}
