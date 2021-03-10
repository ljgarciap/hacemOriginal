<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tb_cliente;
class Tb_clienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       $cliente = Tb_cliente::all();
        return view('cliente.index',['tb_cliente'=>$cliente]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $cliente = Tb_cliente::all();
         return view('cliente.add',['tb_cliente'=>$cliente]);
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
        $cliente = new Tb_cliente();
        $cliente->documento=$request->documento;
        $cliente->nombre=$request->nombre;
        $cliente->apellido=$request->apellido;
        $cliente->direccion=$request->direccion;
        $cliente->telefono=$request->telefono;
        $cliente->correo=$request->correo;
        //$cliente->estado=$request->estado;
        $cliente->save();
        return redirect()->action('Tb_clienteController@index');
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
        $cliente = Tb_cliente::find($id);
        return view('cliente.edit',['tb_cliente'=>$cliente]);
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
        $cliente = Tb_cliente::find($id);
        $cliente->documento=$request->documento;
        $cliente->nombre=$request->nombre;
        $cliente->apellido=$request->apellido;
        $cliente->direccion=$request->direccion;
        $cliente->telefono=$request->telefono;
        $cliente->correo=$request->correo;
        //$cliente->estado=$request->estado;
        $cliente->save();
        return redirect()->action('Tb_clienteController@index');
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
       /*$tb_cliente = Tb_cliente::destroy($id);
        return redirect()->action('Tb_clienteController@index');*/
    }
    public function deactivate(Request $request)
    {
        $tb_cliente=Tb_cliente::findOrFail($request->id);
        $tb_cliente->estado='0';
        $tb_cliente->save();
    }

    public function activate(Request $request)
    {
        $tb_cliente=Tb_proveedor::findOrFail($request->id);
        $tb_cliente->estado='1';
        $tb_cliente->save();
    }
}
