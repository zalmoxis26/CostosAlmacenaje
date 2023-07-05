<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/pedidos/dar_salida', [App\Http\Controllers\PedidoController::class, 'dar_salida'])->name('dar_salida');
Route::get('/pedidos/salidas', [App\Http\Controllers\PedidoController::class, 'salidas'])->name('salidas');
Route::get('/pedidos/{id}/edit_salidas', [App\Http\Controllers\PedidoController::class, 'edit_salidas'])->name('edit_salidas');
Route::patch('/pedidos/salidas/{pedido}/', [App\Http\Controllers\PedidoController::class, 'update_salidas'])->name('update_salidas');

Route::resource('clientes', App\Http\Controllers\ClienteController::class);
Route::resource('pedidos', App\Http\Controllers\PedidoController::class);
Route::resource('revision', App\Http\Controllers\RevisionController::class);


Route::resource('productos', App\Http\Controllers\ProductoController::class);
Route::resource('precios', App\Http\Controllers\PrecioController::class);

//CONTROLLADOR PARA EXCELL
Route::get('/pedidos/exports/exportarSalidas', [PedidoController::class, 'export_SeleccionSalidas'])->name('exportarSalidasSeleccion');
Route::get('/pedidos/exports/exportarTodasSalidas', [PedidoController::class, 'export_salidas'])->name('exportarSalidas');
Route::get('/pedidos/exports/exportarPedidos', [PedidoController::class, 'export'])->name('exportarPedidos');
Route::get('/pedidos/exports/exportarCliente/{id}', [PedidoController::class, 'export_cliente'])->name('exportar_Cliente');

//CONTROLLADOR PARA PDF's

Route::get('/Crear-PDF-ENTRADA/{id}', [PDFController::class, 'index'])->name('PDF_ENTRADA');
