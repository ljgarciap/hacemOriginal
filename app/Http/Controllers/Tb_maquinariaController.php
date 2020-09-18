<?php

namespace App\Http\Controllers;

use App\Tb_maquinaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_maquinariaController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $maquinarias = Tb_maquinaria::orderBy('id','desc')->paginate(5);
        }
        else {
            $maquinarias = Tb_maquinaria::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$maquinarias->total(),
                'current_page'  =>$maquinarias->currentPage(),
                'per_page'      =>$maquinarias->perPage(),
                'last_page'     =>$maquinarias->lastPage(),
                'from'          =>$maquinarias->firstItem(),
                'to'            =>$maquinarias->lastItem(),
            ],
                'maquinarias' => $maquinarias
        ];
    }

    public function selectMaquinaria(){
        $maquinarias = Tb_maquinaria::where('estado','=','1')
        ->select('id as idMaquinaria','maquinaria')->orderBy('maquinaria','asc')->get();

        return ['maquinarias' => $maquinarias];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_maquinaria=new Tb_maquinaria();
        $tb_maquinaria->maquinaria=$request->maquinaria;
        $tb_maquinaria->valor=$request->valor;
        $tb_maquinaria->tiempoDeVidaUtil=$request->tiempoDeVidaUtil;
        $tb_maquinaria->depreciacionAnual=$request->depreciacionAnual;
        $tb_maquinaria->depreciacionMensual=$request->depreciacionMensual;
        $tb_maquinaria->fecha=$request->fecha;
        $tb_maquinaria->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_maquinaria=Tb_maquinaria::findOrFail($request->id);
        $tb_maquinaria->maquinaria=$request->maquinaria;
        $tb_maquinaria->valor=$request->valor;
        $tb_maquinaria->tiempoDeVidaUtil=$request->tiempoDeVidaUtil;
        $tb_maquinaria->depreciacionAnual=$request->depreciacionAnual;
        $tb_maquinaria->depreciacionMensual=$request->depreciacionMensual;
        $tb_maquinaria->fecha=$request->fecha;
        $tb_maquinaria->estado='1';
        $tb_maquinaria->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_maquinaria=Tb_maquinaria::findOrFail($request->id);
        $tb_maquinaria->estado='0';
        $tb_maquinaria->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_maquinaria=Tb_maquinaria::findOrFail($request->id);
        $tb_maquinaria->estado='1';
        $tb_maquinaria->save();
    }
}
