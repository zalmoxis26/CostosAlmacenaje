<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Precio;
use App\Models\Revision;
use App\Models\PedidoProducto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Exports\PedidosExport;
use App\Exports\SalidasExport;
use App\Exports\SeleccionSalidasExport;
use App\Exports\Pedidos_ClienteExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;




class PedidoController extends Controller
{
    public function index(Request $request)
    {
    
      $query = $request->input('search');
    
        $pedidos = Pedido::where('salida', 'NO')->orderBy('fecha_entrada','desc')
                 ->where(function ($q) use ($query) {
                     $q->whereHas('cliente', function ($q) use ($query) {
                           $q->where('name', 'LIKE', "%$query%")
                           ->orWhere('codigo_cliente', 'LIKE', "%$query%");
                       })
                       ->orWhere('factura', 'LIKE', "%$query%")
                       ->orWhere('fecha_entrada', 'LIKE', "%$query%");
                 })
                 ->paginate(10);

     $pedidos->appends(['search' => $query]); // Mantener el valor de búsqueda en la paginación

    $revisions = Revision::all();

    return view('pedido.index', compact('pedidos', 'revisions', 'query'))
            ->with('i');
}
   
    public function create()
    {
        $pedido = new Pedido();
        $clientes=Cliente::all();
        $productos= Producto::all();
        return view('pedido.create', compact('pedido','clientes','productos'));
    }

   
    public function store(Request $request)
    {
        

       $cli=$request['cliente_id'];
       $prod=$request['producto_id'];
      

        $i=0;

      
        //SACAMOS LOS IDS DE LOS PRODUCTOS DEL REQUEST Y LOS ASIGNAMOS A NUESTROS ARRAYS
        foreach($prod as $producto){

        $producto_id[$i] = $request['producto_id'][$i];
        $cantidades[$i] = $request['cantidad'][$i];

         // SACAR ID DEL PRIMER PRECIO
        $precios[$i]= PRECIO::where('cliente_id', $cli)->
                              where('producto_id',$producto_id[$i])->pluck('precio')->first();

        if ($precios[$i]==null) {
	 $precios[$i]=10.00;
     $mensaje= "EL PRECIO DE ESTE CLIENTE NO ESTA ASIGNADO EN EL CATALOGO.\nSE ESTABLECIO EL PRECIO GENERICO: $10.00. POR PRODUCTO.";
        }

        
        
        $i++;


        }


            //sumamos las cantidades
            $suma_cantidades = array_sum($cantidades);

            

        $request['producto_id']=$producto_id[0];
        $request['cantidad']=$suma_cantidades;



        request()->validate(Pedido::$rules);


        $pedido = Pedido::create($request->all());

        $pedido_id=$pedido['id'];

        $j=0;

         //SACAMOS LOS IDS DE LOS PRODUCTOS DEL REQUEST
        foreach($prod as $producto){
        
          $pedido->productos()->attach($pedido_id , ['producto_id' => $producto_id[$j], 'cantidades' => $cantidades[$j] , 'precio' => $precios[$j]]);

          $j++;

        }
         

         return redirect()->route('pedidos.index')->with('success', 'Pedido created successfully.')->with('mensaje', $mensaje);
         

    }

   
        public function show($id)
    {
        $pedido = Pedido::find($id);

        return view('pedido.show', compact('pedido'));
    }

    
    public function edit($id)
    {
        $pedido = Pedido::find($id);
       
        $clientes= Cliente::all();
        $productos= Producto::all();       
       
        return view('pedido.edit', compact('pedido','clientes','productos'));
    }


 
    public function update(Request $request, Pedido $pedido)
    {

          

        $cli=$request['cliente_id'];
        $prod=$request['producto_id'];
        $pedido_id=$pedido['id'];
        $cantidades = $request['cantidad'];
        $precios = $request['precio'];


         $request['codigo_id']= CLIENTE::where('id', $cli)->pluck('id')->first();

               
        
        $i=0;

      
         
            
        //SACAMOS LOS IDS DE LOS PRODUCTOS DEL REQUEST
        foreach($prod as $producto){
         
        $producto_id[$i] = $request['producto_id'][$i];
        $cantidades[$i] = $request['cantidad'][$i];
        $precios[$i] = $request['precio'][$i];
        
        $i++;

       
        
        }

       
       

        // HACEMOS SYNC O ACTULIZAMOS LA TABLA PIVOT PEDIDO_PRODUCTO 
            $data = [];

            foreach ($prod as $i => $unused) {
                $data[$producto_id[$i]] = [
                'cantidades' => $cantidades[$i],
                'precio' => $precios[$i]
                        ];
                      }

        
$pedido->productos()->detach(); // Eliminar cualquier relación existente

$pedido->productos()->sync($data);
    
            //sumamos las cantidades
            $suma_cantidades = array_sum($cantidades);
        

          $request['producto_id']=$producto_id[0];
          $request['cantidad']=$suma_cantidades;
          $request->merge(["precios"=>$precios[0]]);

       
      

        $pedido->update($request->all());

       

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido updated successfully');
    }

  
    public function destroy($id)
    {
        $pedido = Pedido::find($id)->delete();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido deleted successfully');
    }






//----------- TODO LO RELACIONADO A SALIDAS VA ACA----------------------------------------------------------------//



    public function dar_salida(Request $request)
{
    
        
    $ids = $request->input('select_pedidos');

     if (empty($ids)) {
        session()->flash('error', 'NO SE HAN SELECCIONADO PEDIDOS PARA DAR SALIDA.');
        return redirect()->back();
    }

   
        $i=0;
          
      foreach ($ids as $id) {
            
             $pedido = Pedido::find($id);
             

             foreach($pedido->productos()->get() as $producto){

                  

                    $producto_id[$i] = $producto->pivot->producto_id;
                    $cantidades[$i] = $producto->pivot->cantidades;
                    $precios[$i] = $producto->pivot->precio;
                           
                
        $i++;

       
        
        }

        //multiplicamos 2 arrays precios y cantidades por orden y se convinan en uno

        $resultado = [];
        foreach ($cantidades as $j => $cantidad) {
            $resultado[$j] = $cantidad * $precios[$j];
            }

            //sumamos contenidos del array $resultado
            $suma_precios_cantidades = array_sum($resultado);
       
        if ($pedido->salida=='NO') {
	        $pedido->salida = 'SI';
        }else{
             $pedido->salida = 'NO';
        }

        
             
            $pedido->fecha_salida = Carbon::now('America/Los_Angeles');
            $fechaINI = $pedido['fecha_entrada'];
            $fechaFIN = $pedido['fecha_salida'];
            $Totaldias = $fechaINI->diffInDays($fechaFIN);
            // Detectar Domingos y quitarlo
        
         $Domingos = $fechaINI->diffInDaysFiltered(function(Carbon $date) {
                 $date->isSunday();
                }, $fechaFIN);

            $Totaldias=$Totaldias-$Domingos;

            if($Totaldias==0){
                $Totaldias=1;
            }

            $pedido['dias']= $Totaldias;

            //SACAMOS EL TOTAL DEL PEDIDO
             $pedido['total']=$pedido['dias']*$suma_precios_cantidades+$pedido->revision->total_revision;
             

            $pedido->update();
           
        }


       return redirect()->route('salidas');
        
        
    }



     public function salidas(Request $request)
    {

    $query = $request->input('search');
    
        $pedidos = Pedido::where('salida', 'SI')
                 ->where(function ($q) use ($query) {
                     $q->whereHas('cliente', function ($q) use ($query) {
                           $q->where('name', 'LIKE', "%$query%")
                           ->orWhere('codigo_cliente', 'LIKE', "%$query%");
                       })
                       ->orWhere('factura', 'LIKE', "%$query%")
                       ->orWhere('fecha_entrada', 'LIKE', "%$query%");
                 })
                 ->paginate(10);

     $pedidos->appends(['search' => $query]); // Mantener el valor de búsqueda en la paginación

      
         $i=0;  
        

        return view('pedido.salidas', compact('pedidos','i', 'query'));
    }
    

    public function edit_salidas($id)
    {
        $pedido = Pedido::find($id);
        
        $clientes= Cliente::all();
        $productos= Producto::all();       
       
        return view('pedido.edit_salidas', compact('pedido','clientes','productos'));
    }

    public function update_salidas(Request $request, Pedido $pedido)


    {

        $cli=$request['cliente_id'];
        $prod=$request['producto_id'];
        $pedido_id=$pedido['id'];
        $cantidades = $request['cantidad'];
         $precios = $request['precio'];

           

         $request['codigo_id']= CLIENTE::where('id', $cli)->pluck('id')->first();

               
        
        $i=0;

      
         
            
        //SACAMOS LOS IDS DE LOS PRODUCTOS DEL REQUEST
        foreach($prod as $producto){
         
        $producto_id[$i] = $request['producto_id'][$i];
        $cantidades[$i] = $request['cantidad'][$i];
        $precios[$i] = $request['precio'][$i];
        
        $i++;

       
        
        }

       

        // HACEMOS SYNC O ACTULIZAMOS LA TABLA PIVOT PEDIDO_PRODUCTO 
            $data = [];

            foreach ($prod as $i => $unused) {
                $data[$producto_id[$i]] = [
                'cantidades' => $cantidades[$i],
                'precio' => $precios[$i]
                        ];
                      }

                     
            $pedido->productos()->detach(); // Eliminar cualquier relación existente
              $pedido->productos()->sync($data);
       
            
    
            //sumamos las cantidades
            $suma_cantidades = array_sum($cantidades);
        
            
          $request['producto_id']=$producto_id[0];
          $request['cantidad']=$suma_cantidades;
          $request->merge(["precios"=>$precios[0]]);

            
          // AQUI CALCULAMOS LOS DIAS

         
            $fechaINI = $pedido['fecha_entrada'];
            $fechaFIN = $request['fecha_salida'];
            
            $Totaldias = $fechaINI->diffInDays($fechaFIN);
            // Detectar Domingos y quitarlo
        
         $Domingos = $fechaINI->diffInDaysFiltered(function(Carbon $date) {
                 $date->isSunday();
                }, $fechaFIN);

            $Totaldias=$Totaldias-$Domingos;

            if($Totaldias==0){
                $Totaldias=1;
            }

            $pedido['dias']= $Totaldias;


        //multiplicamos 2 arrays precios y cantidades por orden y se combinan en uno

        $resultado = [];
        foreach ($cantidades as $j => $cantidad) {
            $resultado[$j] = $cantidad * $precios[$j];
            }

            //sumamos contenidos del array $resultado
            $suma_precios_cantidades = array_sum($resultado);


              //AQUI SACAMOS EL TOTAL DEL PEDIDO

             $pedido['total']=$pedido['dias']*$suma_precios_cantidades+$pedido->revision->total_revision;

       //ACTUALIZAMOS LA REVISION
        $revision = Revision::find($pedido->revision_id);

// Verificar si el ID existente es igual a 1
if ($revision->id === 1) {
    // Obtener el siguiente ID disponible
    $nuevoID = Revision::max('id') + 1;

    // Crear un nuevo registro en la tabla Revision con el nuevo ID
    $nuevaRevision = new Revision;
    $nuevaRevision->id = $nuevoID;
    $nuevaRevision->revisor = $request['revisor'];
    $nuevaRevision->total_revision = $request['total_revision'];
    $nuevaRevision->save();

    // Actualizar el campo revision_id en la tabla pedidos
    $pedido->revision_id = $nuevoID;
} else {
    // Actualizar los campos de la revisión existente
    $revision->revisor = $request['revisor'];
    $revision->total_revision = $request['total_revision'];
}

$revision->save();




        //ACTUALIZAMOS PEDIDO CON EL request
        $pedido->update($request->all());

        return redirect()->route('salidas')
            ->with('success', 'SALIDA ACTUALIZADA CORRECTAMENTE');
    }

//----------- TODO LO RELACIONADO A EXCEL EXPORTS----------------------------------------------------------------//


    public function export() {

    return Excel::download(new PedidosExport, 'entradas.xlsx');

    }


    public function export_salidas() {

    return Excel::download(new SalidasExport, 'salidas.xlsx');

    }

     public function export_cliente($id) {

     $cliente= Cliente::where('id',$id)->get();

     


    return Excel::download(new Pedidos_ClienteExport, 'ENTRADAS Y SALIDAS DE ' . $cliente->pluck('name') . '.xlsx');

    }

    public function export_SeleccionSalidas(Request $request) 
    {

   

        $selectedPedidos = request()->input('select_pedidos', []);

    return Excel::download(new SeleccionSalidasExport($selectedPedidos), 'pedidos_seleccionados.xlsx');
    }
}
