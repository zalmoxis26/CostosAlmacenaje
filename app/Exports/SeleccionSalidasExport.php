<?php

namespace App\Exports;

use App\Models\Pedido;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;

class SeleccionSalidasExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $selectedPedidos = request()->input('select_pedidos', []);

        return view('pedido.pedido_excel', [
            'i' => -1,
            'pedidos' => Pedido::whereIn('id', $selectedPedidos)->where('salida', 'SI')->get()
        ]);
    }
}
