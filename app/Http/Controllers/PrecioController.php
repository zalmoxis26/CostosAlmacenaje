<?php

namespace App\Http\Controllers;

use App\Models\Precio;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

/**
 * Class PrecioController
 * @package App\Http\Controllers
 */
class PrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $precios = Precio::orderBy('cliente_id')->get();

        return view('precio.index', compact('precios'))
            ->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $precio = new Precio();
        $clientes=Cliente::all();
        $productos= Producto::all();
        return view('precio.create', compact('precio', 'productos', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Precio::$rules);

       

        if (!is_numeric($request['producto_id'])) {
              
           
        $ProductoNvo = [];

        $ProductoNvo = array_merge($ProductoNvo, ["name" => $request['producto_id'], "precio" => $request['precio']]);
       
        $checarProducto = Producto::where('name', $ProductoNvo['name'])->where('precio', $ProductoNvo['precio'])->pluck('id')->first();
  
        //SI EL PRODUCTO NO EXISTE

        if($checarProducto == ''){


            $producto = Producto::create($ProductoNvo);
             $request['producto_id']= $producto['id'];  
        }

        if (!is_numeric($request['producto_id'])) {
              $request['producto_id']=$checarProducto;
            }
  
        }
            
        $precio = Precio::create($request->all());

        return redirect()->route('precios.index')
            ->with('success', 'Precio created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $precio = Precio::find($id);

        return view('precio.show', compact('precio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $precio = Precio::find($id);
       
        $cliente= Cliente::all();
        $productos= Producto::all();
        return view('precio.edit', compact('precio','cliente', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Precio $precio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Precio $precio)
    {
        request()->validate(Precio::$rules);

        $precio->update($request->all());

        return redirect()->route('precios.index')
            ->with('success', 'Precio updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $precio = Precio::find($id)->delete();

        return redirect()->route('precios.index')
            ->with('success', 'Precio deleted successfully');
    }
}
