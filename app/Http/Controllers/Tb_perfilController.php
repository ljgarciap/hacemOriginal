<?php

namespace App\Http\Controllers;

use App\Tb_perfil;
use App\Tb_proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_perfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfiles = Tb_perfil::all();
        $procesos = Tb_proceso::all();
        return view('perfil.index', ['perfiles'=>$perfiles,'procesos'=>$procesos] );
    }

    public function create()
    {
        $procesos = Tb_proceso::all();
        return view('perfil.create',['procesos'=>$procesos]);
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
        $datosPerfiles =request()->except('_token');
        Tb_perfil::insert($datosPerfiles);
        //return response()->json($datosMaterias);
        return redirect('perfil');
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materias  $materias
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perfiles = Tb_perfil::whereId($id)->firstOrFail();
        $procesos = Tb_proceso::all();

        return view('perfil.edit', ['perfiles'=>$perfiles,'procesos'=>$procesos]);
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
            $datosPerfil=request()->except(['_token','_method']);
            Tb_perfil::where('id','=',$id)->update($datosPerfil);
            // Guardamos en base de datos
            return redirect(action('Tb_perfilController@index'));
    }

    public function deactivate($id)
    {
         $user = DB::table('tb_perfil')->find($id);
        if($user->estado===1){
            Tb_perfil::where('id','=',$id)->update(['estado' => 0]);
        }
        else{
            Tb_perfil::where('id','=',$id)->update(['estado' => 1]);
        }
        return redirect(action('Tb_perfilController@index'));
    }

}
