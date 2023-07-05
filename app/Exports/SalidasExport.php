<?php

namespace App\Exports;

use App\Models\Pedido;
use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalidasExport implements FromView
{
    public function view(): View
    {
        return view('pedido.excel_salidas', [
            'i' => -1,
            'pedidos' => Pedido::all()
        ]);
    }
}

