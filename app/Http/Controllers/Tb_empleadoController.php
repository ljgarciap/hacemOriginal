<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tb_empleado;
use App\Tb_perfil;
class Tb_empleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $tb_perfil = Tb_perfil::all();
         $tb_empleado = Tb_empleado::all();
         return view('empleado.index',['tb_empleado'=>$tb_empleado], ['tb_perfil'=>$tb_perfil]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tb_perfil = Tb_perfil::all();
        $tb_empleado = Tb_empleado::all();
        return view('empleado.add',['tb_empleado'=>$tb_empleado], ['tb_perfil'=>$tb_perfil]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $tb_perfil = Tb_perfil::all();
        $tb_empleado = new Tb_empleado();
        $tb_empleado->documento=$request->documento;
        $tb_empleado->nombre=$request->nombre;
        $tb_empleado->apellido=$request->apellido;
        $tb_empleado->direccion=$request->direccion;
        $tb_empleado->telefono=$request->telefono;
        $tb_empleado->idPerfil=$request->idPerfil;
        $tb_empleado->correo=$request->correo;
        //$tb_empleado->estado=$request->estado;
        $tb_empleado->save();
        return redirect()->action('Tb_empleadoController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tb_perfil = Tb_perfil::all();
        $tb_empleado = Tb_empleado::find($id);
        return view('empleado.edit',['tb_empleado'=>$tb_empleado],['tb_perfil'=>$tb_perfil]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $tb_empleado =Tb_empleado::find($id);
        $tb_empleado->documento=$request->documento;
        $tb_empleado->nombre=$request->nombre;
        $tb_empleado->apellido=$request->apellido;
        $tb_empleado->direccion=$request->direccion;
        $tb_empleado->telefono=$request->telefono;
        $tb_empleado->idPerfil=$request->idPerfil;
        $tb_empleado->correo=$request->correo;
        //$tb_empleado->estado=$request->estado;
        $tb_empleado->save();
        return redirect()->action('Tb_empleadoController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       /* $tb_empleado = Tb_empleado::destroy($id);
        return redirect()->action('Tb_empleadoController@index');*/
    }
    public function deactivate(Request $request)
    {
        $tb_empleado=Tb_empleado::findOrFail($request->id);
        $tb_empleado->estado='0';
        $tb_empleado->save();
    }

    public function activate(Request $request)
    {
        $tb_empleado=Tb_empleado::findOrFail($request->id);
        $tb_empleado->estado='1';
        $tb_empleado->save();
    }
}
