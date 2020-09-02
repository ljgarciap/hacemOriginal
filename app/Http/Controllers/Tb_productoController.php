<?php

namespace App\Http\Controllers;

use App\Tb_producto;
use App\Tb_coleccion;
use App\Tb_area;
use App\Tb_hoja_de_costo;
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
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $productos = Tb_hoja_de_costo::join('tb_producto','tb_hoja_de_costo.idProducto','=','tb_producto.id')
            ->join('tb_coleccion','tb_producto.idColeccion','=','tb_coleccion.id')
            ->leftJoin('tb_area',function($join){
                $join->on('tb_producto.idArea','=','tb_area.id');
            })
            ->select('tb_hoja_de_costo.id as idHojaDeCosto','tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto','tb_producto.descripcion','tb_producto.estado','tb_coleccion.id as idColeccion','tb_coleccion.coleccion','tb_coleccion.estado as estado_coleccion','tb_area.id as idArea','tb_area.area','tb_area.estado as estado_area')
            ->orderBy('tb_producto.id','desc')->paginate(5);
        }
        else if($criterio=='coleccion'){
            $productos = Tb_hoja_de_costo::join('tb_producto','tb_hoja_de_costo.idProducto','=','tb_producto.id')
            ->join('tb_coleccion','tb_producto.idColeccion','=','tb_coleccion.id')
            ->leftJoin('tb_area',function($join){
                $join->on('tb_producto.idArea','=','tb_area.id');
            })
            ->select('tb_hoja_de_costo.id as idHojaDeCosto','tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto','tb_producto.descripcion','tb_producto.estado','tb_coleccion.id as idColeccion','tb_coleccion.coleccion','tb_coleccion.estado as estado_coleccion','tb_area.id as idArea','tb_area.area','tb_area.estado as estado_area')
            ->where('tb_coleccion.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_producto.id','desc')->paginate(5);
        }
        else if($criterio=='area'){
            $productos = Tb_hoja_de_costo::join('tb_producto','tb_hoja_de_costo.idProducto','=','tb_producto.id')
            ->join('tb_coleccion','tb_producto.idColeccion','=','tb_coleccion.id')
            ->leftJoin('tb_area',function($join){
                $join->on('tb_producto.idArea','=','tb_area.id');
            })
            ->select('tb_hoja_de_costo.id as idHojaDeCosto','tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto','tb_producto.descripcion','tb_producto.estado','tb_coleccion.id as idColeccion','tb_coleccion.coleccion','tb_coleccion.estado as estado_coleccion','tb_area.id as idArea','tb_area.area','tb_area.estado as estado_area')
            ->where('tb_area.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_producto.id','desc')->paginate(5);
        }
        else {
            $productos = Tb_hoja_de_costo::join('tb_producto','tb_hoja_de_costo.idProducto','=','tb_producto.id')
            ->join('tb_coleccion','tb_producto.idColeccion','=','tb_coleccion.id')
            ->leftJoin('tb_area',function($join){
                $join->on('tb_producto.idArea','=','tb_area.id');
            })
            ->select('tb_hoja_de_costo.id as idHojaDeCosto','tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto','tb_producto.descripcion','tb_producto.estado','tb_coleccion.id as idColeccion','tb_coleccion.coleccion','tb_coleccion.estado as estado_coleccion','tb_area.id as idArea','tb_area.area','tb_area.estado as estado_area')
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

    public function selectProducto(){
        $productos = Tb_producto::where('estado','=','1')
        ->select('id as idProducto','producto')->orderBy('producto','asc')->get();

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
        $tb_producto->idArea=$request->idArea;
        $tb_producto->save();

        $idProducto=$tb_producto->id;

        $tb_hoja_de_costo=new Tb_hoja_de_costo();
        $tb_hoja_de_costo->idProducto=$idProducto;
        $tb_hoja_de_costo->save();
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
        $tb_producto->idArea=$request->idArea;
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
