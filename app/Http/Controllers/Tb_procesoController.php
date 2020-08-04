<?php

namespace App\Http\Controllers;

use App\Tb_area;
use App\Tb_proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_procesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procesos = Tb_proceso::all();
        $areas = Tb_area::all();
        return view('proceso.index', ['procesos'=>$procesos,'areas'=>$areas ] );
    }

    public function create()
    {
        $areas = Tb_area::all();
        return view('proceso.create',['areas'=>$areas]);
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
        $datosProcesos =request()->except('_token');
        Tb_proceso::insert($datosProcesos);
        //return response()->json($datosMaterias);
        return redirect('proceso');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materias  $materias
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $procesos = Tb_proceso::whereId($id)->firstOrFail();
        $areas = Tb_area::all();

        return view('proceso.edit', ['procesos'=>$procesos,'areas'=>$areas]);
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
        // Seteamos un nuevo titulo
            $datosProceso=request()->except(['_token','_method']);
            Tb_proceso::where('id','=',$id)->update($datosProceso);
            // Guardamos en base de datos
            return redirect(action('Tb_procesoController@index'));
    }

    public function deactivate($id)
    {
         $user = DB::table('tb_proceso')->find($id);
        if($user->estado===1){
            Tb_proceso::where('id','=',$id)->update(['estado' => 0]);
        }
        else{
            Tb_proceso::where('id','=',$id)->update(['estado' => 1]);
        }
        return redirect(action('Tb_procesoController@index'));
    }

}
