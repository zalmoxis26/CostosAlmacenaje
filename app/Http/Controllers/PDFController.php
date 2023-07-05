<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\Pedido;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Dompdf\Dompdf;

class PDFController extends Controller
{
    public function index($id){
    $pedido = Pedido::where('id', $id)
                    ->where('salida', 'NO')
                    ->first();

     

      $qrCode = QrCode::size(300)->generate('http://localhost:8000/pedidos/' . $id);
    $qrCodeData = 'data:image/png;base64,' . base64_encode($qrCode);

    $pdf = new Dompdf();
                       

        $pdf = PDF::loadView('pedido.pdf_show', ['pedido' => $pedido, 'qrCodeData' => $qrCodeData]);

        return $pdf->download('pedido.pdf');
    }
}


