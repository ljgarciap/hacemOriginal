<?php

namespace App\Http\Controllers;
use App\Tb_nomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_nominaController extends Controller
{
    //
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $nomina = Tb_nomina::select('tb_nomina.id','tb_nomina.fechaInicio as fecha','tb_nomina.fechaFin','tb_nomina.estado')
            ->orderBy('tb_nomina.id','desc')->paginate(5);
        }
        else {
            # code...
            $nomina = Tb_nomina::select('tb_nomina.id','tb_nomina.fechaInicio as fecha','tb_nomina.fechaFin','tb_nomina.estado')
            ->where('tb_nomina.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_nomina.id','desc')->paginate(5);

        }

        return [
            'pagination' => [
                'total'         =>$nomina->total(),
                'current_page'  =>$nomina->currentPage(),
                'per_page'      =>$nomina->perPage(),
                'last_page'     =>$nomina->lastPage(),
                'from'          =>$nomina->firstItem(),
                'to'            =>$nomina->lastItem(),
            ],
                'nomina' => $nomina
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=new Tb_nomina();
        $tb_nomina->fechaInicio=$request->fechaInicio;
        //$tb_nomina->fechaFin=$request->fechaFin;
        $tb_nomina->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=Tb_nomina::findOrFail($request->id);
        //$tb_nomina->fechaInicio=$request->fechaInicio;
        $tb_nomina->fechaFIn=$request->fechaFin;
        $tb_nomina->estado=1;
        $tb_nomina->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=Tb_nomina::findOrFail($request->id);
        $tb_nomina->estado=0;
        $tb_nomina->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=Tb_nomina::findOrFail($request->id);
        $tb_nomina->estado=1;
        $tb_nomina->save();
    }
}
