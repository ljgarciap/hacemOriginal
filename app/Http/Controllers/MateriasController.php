<?php

namespace App\Http\Controllers;

use App\Materias;
use App\UnidadBase;
use App\TipoMaterial;
use Illuminate\Http\Request;

class MateriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $datos['materias']=Materias::paginate(5);
        return view('materias.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = UnidadBase::all();
        $tipos = TipoMaterial::all();
        return view('materias.create', ['unidades'=>$unidades, 'tipos'=>$tipos] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //$datosMaterias = request()->all();
        $datosMaterias =request()->except('_token');
        Materias::insert($datosMaterias);
        //return response()->json($datosMaterias);
        return redirect('materias');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materias  $materias
     * @return \Illuminate\Http\Response
     */
    public function show(Materias $materias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materias  $materias
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unidades = UnidadBase::all();
        $tipos = TipoMaterial::all();
        $materia=Materias::findOrFail($id);
        return view('materias.edit',['materia'=>$materia,'unidades'=>$unidades,'tipos'=>$tipos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materias  $materias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $unidades = UnidadBase::all();
        $tipos = TipoMaterial::all();
        $datosMateria=request()->except(['_token','_method']);
        Materias::where('id','=',$id)->update($datosMateria);

        $materia=Materias::findOrFail($id);

        return redirect()->action('MateriasController@index');
        //return view('materias.edit',['materia'=>$materia,'unidades'=>$unidades,'tipos'=>$tipos]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materias  $materias
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $materia=Materias::findOrFail($id);
        Materias::destroy($id);
        return redirect('materias');
    }
}
