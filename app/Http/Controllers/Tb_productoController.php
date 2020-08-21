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
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $productos = Tb_producto::join('tb_coleccion','tb_producto.idColeccion','=','tb_coleccion.id')
            ->select('tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto','tb_producto.descripcion','tb_producto.estado','tb_coleccion.id as id_coleccion','tb_coleccion.coleccion','tb_coleccion.referencia','tb_coleccion.estado as estado_coleccion')
            ->orderBy('tb_producto.id','desc')->paginate(5);
        }
        else if($criterio=='coleccion'){
            $productos = Tb_producto::join('tb_coleccion','tb_producto.idColeccion','=','tb_coleccion.id')
            ->select('tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto','tb_producto.descripcion','tb_producto.estado','tb_coleccion.id as id_coleccion','tb_coleccion.coleccion','tb_coleccion.referencia','tb_coleccion.estado as estado_coleccion')
            ->where('tb_coleccion.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_producto.id','desc')->paginate(5);
        }
        else {
            # code...
            $productos = Tb_producto::join('tb_coleccion','tb_producto.idColeccion','=','tb_coleccion.id')
            ->select('tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto','tb_producto.descripcion','tb_producto.estado','tb_coleccion.id as id_coleccion','tb_coleccion.coleccion','tb_coleccion.referencia','tb_coleccion.estado as estado_coleccion')
            ->where('tb_producto.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_producto.id','desc')->paginate(5);

        }

        return [
            'pagination' => [
                'total'         =>$productos->total(),
                'current_page'  =>$productos->currentPage(),
                'per_page'      =>$productos->perPage(),
                'last_page'     =>$productos->lastPage(),
                'from'          =>$productos->firstItem(),
                'to'            =>$productos->lastItem(),
            ],
                'productos' => $productos
        ];
    }

    public function selectProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $productos = Tb_producto::where('estado','=','1')
        ->select('id','producto')->orderBy('producto','asc')->get();

        return ['productos' => $productos];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $tb_producto=new Tb_producto();
        $tb_producto->producto=$request->producto;
        $tb_producto->referencia=$request->referencia;
        $tb_producto->foto=$request->foto;
        $tb_producto->descripcion=$request->descripcion;
        $tb_producto->idColeccion=$request->idColeccion;
        $tb_producto->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $tb_producto=Tb_producto::findOrFail($request->id);
        $tb_producto->producto=$request->producto;
        $tb_producto->referencia=$request->referencia;
        $tb_producto->foto=$request->foto;
        $tb_producto->descripcion=$request->descripcion;
        $tb_producto->idColeccion=$request->idColeccion;
        $tb_producto->estado='1';
        $tb_producto->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $tb_producto=Tb_producto::findOrFail($request->id);
        $tb_producto->estado='0';
        $tb_producto->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $tb_producto=Tb_producto::findOrFail($request->id);
        $tb_producto->estado='1';
        $tb_producto->save();
    }
}
