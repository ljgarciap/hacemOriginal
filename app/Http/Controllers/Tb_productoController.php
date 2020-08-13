<?php

namespace App\Http\Controllers;

use App\Tb_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Tb_productoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['productos']=Tb_producto::paginate(5);
        return view('producto.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('producto.create',['idColeccion'=>$id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosProducto=request()->except('_token');
            if ($request->hasFile('foto')){
                $datosProducto['foto']=$request->file('foto')->store('uploads','public');
            }
        Tb_producto::insert($datosProducto);
        //return response()->json($datosProducto);
        return redirect()->route('coleccion.show', ['coleccion'=>$request->idColeccion]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tb_producto  $tb_producto
     * @return \Illuminate\Http\Response
     */
    public function show(Tb_producto $tb_producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tb_producto  $tb_producto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto= Tb_producto::findOrFail($id);
        return view('producto.edit',compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tb_producto  $tb_producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datosProducto=request()->except(['_token','_method']);

        if ($request->hasFile('foto')){
            $producto= Tb_producto::findOrFail($id);
            Storage::delete(['public/'.$producto->foto]);
            $datosProducto['foto']=$request->file('foto')->store('uploads','public');
        }

        Tb_producto::where('id','=',$id)->update($datosProducto);

        //$producto= Tb_producto::findOrFail($id);
        //return view('producto.edit',compact('producto'));*/
        return redirect()->route('coleccion.show', ['coleccion'=>$request->idColeccion]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tb_producto  $tb_producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return redirect()->route('coleccion.show', ['coleccion'=>$id]);
    }
}
