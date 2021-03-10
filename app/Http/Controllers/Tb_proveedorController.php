<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tb_proveedor;
class Tb_proveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $proveedor = Tb_proveedor::all();
        return view('proveedor.index',['tb_proveedor' =>$proveedor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         return view('proveedor.add');
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
        $proveedor = new Tb_proveedor();
        $proveedor->nit=$request->nit;
        $proveedor->razonSocial=$request->razonSocial;
        $proveedor->contacto=$request->contacto;
        $proveedor->telefono=$request->telefono;
        $proveedor->direccion=$request->direccion;
        $proveedor->correo=$request->correo;
        //$tb_proveedor->estado=$request->estado;
        $proveedor->save();
        return redirect()->action('Tb_proveedorController@index');
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
        $proveedor = Tb_proveedor::find($id);
        return view('proveedor.edit',['tb_proveedor'=>$proveedor]);
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
        $proveedor = Tb_proveedor::find($id);
        $proveedor->nit=$request->nit;
        $proveedor->razonSocial=$request->razonSocial;
        $proveedor->contacto=$request->contacto;
        $proveedor->telefono=$request->telefono;
        $proveedor->direccion=$request->direccion;
        $proveedor->correo=$request->correo;
        //$proveedor->estado=$request->estado;
        $proveedor->save();
        return redirect()->action('Tb_proveedorController@index');
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
          /* $proveedor= Tb_proveedor::find($id);
           $proveedor->delete();
          return redirect()->action('Tb_proveedorController@index');*/
    }
    public function deactivate(Request $request)
    {
        $tb_proveedor=Tb_proveedor::findOrFail($request->id);
        $tb_proveedor->estado='0';
        $tb_proveedor->save();
    }

    public function activate(Request $request)
    {
        $tb_proveedor=Tb_proveedor::findOrFail($request->id);
        $tb_proveedor->estado='1';
        $tb_proveedor->save();
    }
}
