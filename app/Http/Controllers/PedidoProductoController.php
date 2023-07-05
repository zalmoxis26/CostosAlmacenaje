<?php

namespace App\Http\Controllers;

use App\Models\PedidoProducto;
use Illuminate\Http\Request;

/**
 * Class PedidoProductoController
 * @package App\Http\Controllers
 */
class PedidoProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidoProductos = PedidoProducto::paginate();

        return view('pedido-producto.index', compact('pedidoProductos'))
            ->with('i', (request()->input('page', 1) - 1) * $pedidoProductos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pedidoProducto = new PedidoProducto();
        return view('pedido-producto.create', compact('pedidoProducto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(PedidoProducto::$rules);

        $pedidoProducto = PedidoProducto::create($request->all());

        return redirect()->route('pedido-productos.index')
            ->with('success', 'PedidoProducto created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
   /* public function show($id)
    {
        $pedidoProducto = PedidoProducto::find($id);

        return view('pedido-producto.show', compact('pedidoProducto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedidoProducto = PedidoProducto::find($id);

        return view('pedido-producto.edit', compact('pedidoProducto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  PedidoProducto $pedidoProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PedidoProducto $pedidoProducto)
    {
        request()->validate(PedidoProducto::$rules);

        $pedidoProducto->update($request->all());

        return redirect()->route('pedido-productos.index')
            ->with('success', 'PedidoProducto updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pedidoProducto = PedidoProducto::find($id)->delete();

        return redirect()->route('pedido-productos.index')
            ->with('success', 'PedidoProducto deleted successfully');
    }
}
