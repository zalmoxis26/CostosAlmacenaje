<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;

class Pedidos_ClienteExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $id = request()->route('id');

        return view('pedido.pedido_excel', [
            'i' => -1,
            'pedidos' => Pedido::where('cliente_id', $id)->get()
        ]);
    }
}

