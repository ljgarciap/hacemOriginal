<?php

namespace App\Http\Controllers;

use App\Tb_simulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_simulacionController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $simulaciones = Tb_simulacion::orderBy('id','desc')->paginate(5);
        }
        else {
            $simulaciones = Tb_simulacion::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$simulaciones->total(),
                'current_page'  =>$simulaciones->currentPage(),
                'per_page'      =>$simulaciones->perPage(),
                'last_page'     =>$simulaciones->lastPage(),
                'from'          =>$simulaciones->firstItem(),
                'to'            =>$simulaciones->lastItem(),
            ],
                'simulaciones' => $simulaciones
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_simulacion=new Tb_simulacion();
        $tb_simulacion->descripcion=$request->detalle;
        $tb_simulacion->fecha=$request->fecha;
        $tb_simulacion->tipoCif=$request->tipoCif;
        $tb_simulacion->save();
    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_simulacion=Tb_simulacion::findOrFail($request->id);
        $tb_simulacion->estado=1;
        $tb_simulacion->save();
    }
}
