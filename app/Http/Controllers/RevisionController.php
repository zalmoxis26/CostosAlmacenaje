<?php

namespace App\Http\Controllers;

use App\Models\Revision;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Carbon\Carbon;


/**
 * Class RevisionController
 * @package App\Http\Controllers
 */
class RevisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $revisions = Revision::paginate();

        return view('revision.index', compact('revisions'))
            ->with('i', (request()->input('page', 1) - 1) * $revisions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $revision = new Revision();
        return view('revision.create', compact('revision'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate(Revision::$rules);

 // TODO ESTO ES PA CALCULAR HORAS Y MINUTOS DE LA REVISION

       $fechaINI = Carbon::parse($request['inicio_revision']);
       $fechaFIN = Carbon::parse($request['fin_revision']);
       $TotalMinutos = $fechaINI->diffInMinutes($fechaFIN);
       $TotalHoras = floor($TotalMinutos / 60);
       $TotalMinutosRestantes = $TotalMinutos % 60;

    /*    if ($TotalMinutosRestantes > 30) {
        $TotalHoras++;  // Ajuste para redondear hacia arriba si los minutos superan los 30
        $TotalMinutosRestantes = 0;  // Establecer los minutos en 0
    }*/
        $TiempoTotal= $TotalHoras +  round($TotalMinutosRestantes / 60, 2);

        $HorasHumano = $TotalHoras . " horas y " . $TotalMinutosRestantes . " minutos";

        // VER HORAS Y MINUTOS
        //  return $TiempoTotal . ' que es igual a ' . $HorasHumano;

        $request['total_revision']= $request['precio_revision'] * $TiempoTotal;

   
 
        $revision = Revision::create($request->all());

        //SE LE ASIGNA EL ID DE LA REVISION CREADA AL PEDIDO DONDE SE LLENO EL FORMULARIO
        $pedido= Pedido::find($request->pedido_id);
        $pedido->update(['revision_id' => $revision->id]);

          
        

        return redirect()->route('pedidos.index')
            ->with('success', 'Revision creada con exito, para: ' . $revision->revisor . ' Con un tiempo de: '. $HorasHumano . ' de revision.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $revision = Revision::find($id);

        return view('revision.show', compact('revision'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $revision = Revision::find($id);

        return view('revision.edit', compact('revision'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Revision $revision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Revision $revision)
    {
        request()->validate(Revision::$rules);

        $revision->update($request->all());

        return redirect()->route('revision.index')
            ->with('success', 'Revision updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $revision = Revision::find($id)->delete();

        return redirect()->route('revision.index')
            ->with('success', 'Revision deleted successfully');
    }
}
