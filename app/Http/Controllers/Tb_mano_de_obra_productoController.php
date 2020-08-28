<?php

namespace App\Http\Controllers;

use App\Tb_mano_de_obra_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Tb_mano_de_obra_productoController extends Controller
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
            $manodeobra = Tb_mano_de_obra_producto::join("tb_perfil","tb_mano_de_obra_producto.idPerfil","=","tb_perfil.id")
            ->join("tb_proceso","tb_perfil.idProceso","=","tb_proceso.id")
            ->join("tb_hoja_de_costo","tb_mano_de_obra_producto.idHoja","=","tb_hoja_de_costo.id")
            ->leftJoin('tb_area',function($join){
                $join->on('tb_area.id','=','tb_proceso.idArea');
            })
            ->select('tb_mano_de_obra_producto.id','tb_mano_de_obra_producto.idPerfil','tb_proceso.idArea','tb_area.area','tb_perfil.idProceso as idProceso','tb_proceso.proceso','tb_perfil.perfil','tb_perfil.valorMinuto','tb_mano_de_obra_producto.precio','tb_mano_de_obra_producto.tiempo','tb_hoja_de_costo.id as idHoja')
            ->orderBy('tb_perfil.id','desc')->paginate(5);
        }
        else if($criterio=='perfil'){
            $manodeobra = Tb_mano_de_obra_producto::join("tb_perfil","tb_mano_de_obra_producto.idPerfil","=","tb_perfil.id")
            ->join("tb_proceso","tb_perfil.idProceso","=","tb_proceso.id")
            ->join("tb_hoja_de_costo","tb_mano_de_obra_producto.idHoja","=","tb_hoja_de_costo.id")
            ->leftJoin('tb_area',function($join){
                $join->on('tb_area.id','=','tb_proceso.idArea');
            })
            ->select('tb_mano_de_obra_producto.id','tb_mano_de_obra_producto.idPerfil','tb_proceso.idArea','tb_area.area','tb_perfil.idProceso as idProceso','tb_proceso.proceso','tb_perfil.perfil','tb_perfil.valorMinuto','tb_mano_de_obra_producto.precio','tb_mano_de_obra_producto.tiempo','tb_hoja_de_costo.id as idHoja')
            ->orderBy('tb_perfil.id','desc')->paginate(5);
        }
        else {
            $manodeobra = Tb_mano_de_obra_producto::join("tb_perfil","tb_mano_de_obra_producto.idPerfil","=","tb_perfil.id")
            ->join("tb_proceso","tb_perfil.idProceso","=","tb_proceso.id")
            ->join("tb_hoja_de_costo","tb_mano_de_obra_producto.idHoja","=","tb_hoja_de_costo.id")
            ->leftJoin('tb_area',function($join){
                $join->on('tb_area.id','=','tb_proceso.idArea');
            })
            ->select('tb_mano_de_obra_producto.id','tb_mano_de_obra_producto.idPerfil','tb_proceso.idArea','tb_area.area','tb_perfil.idProceso as idProceso','tb_proceso.proceso','tb_perfil.perfil','tb_perfil.valorMinuto','tb_mano_de_obra_producto.precio','tb_mano_de_obra_producto.tiempo','tb_hoja_de_costo.id as idHoja')
            ->orderBy('tb_perfil.id','desc')->paginate(5);

        }

        return [
            'pagination' => [
                'total'         =>$manodeobra->total(),
                'current_page'  =>$manodeobra->currentPage(),
                'per_page'      =>$manodeobra->perPage(),
                'last_page'     =>$manodeobra->lastPage(),
                'from'          =>$manodeobra->firstItem(),
                'to'            =>$manodeobra->lastItem(),
            ],
                'manodeobra' => $manodeobra
        ];
    }

    public function selectManoDeObraProducto(){
        $manodeobra = Tb_mano_de_obra_producto::where('estado','=','1')
        ->select('id as idPerfil','perfil')->orderBy('perfil','asc')->get();

        return ['manodeobra' => $manodeobra];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_mano_de_obra_producto=new Tb_mano_de_obra_producto();
        $tb_mano_de_obra_producto->idPerfil=$request->idPerfil;
        $tb_mano_de_obra_producto->tiempo=$request->tiempo;
        $tb_mano_de_obra_producto->precio=$request->precio;
        $tb_mano_de_obra_producto->idHoja=$request->idHoja;
        $tb_mano_de_obra_producto->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_mano_de_obra_producto=Tb_mano_de_obra_producto::findOrFail($request->id);
        $tb_mano_de_obra_producto->idPerfil=$request->idPerfil;
        $tb_mano_de_obra_producto->tiempo=$request->tiempo;
        $tb_mano_de_obra_producto->precio=$request->precio;
        $tb_mano_de_obra_producto->idHoja=$request->idHoja;
        $tb_mano_de_obra_producto->estado='1';
        $tb_mano_de_obra_producto->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_mano_de_obra_producto=Tb_mano_de_obra_producto::findOrFail($request->id);
        $tb_mano_de_obra_producto->estado='0';
        $tb_mano_de_obra_producto->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_mano_de_obra_producto=Tb_mano_de_obra_producto::findOrFail($request->id);
        $tb_mano_de_obra_producto->estado='1';
        $tb_mano_de_obra_producto->save();
    }
}
