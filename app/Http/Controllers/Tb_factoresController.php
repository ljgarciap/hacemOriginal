<?php

namespace App\Http\Controllers;

use App\Tb_factores_nomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_factoresController extends Controller
{
    //
    public function index()
    {
        //if(!$request->ajax()) return redirect('/');
        $factores = Tb_factores_nomina::where('id','=','1')
        ->select('id','extraDiurna','extraNocturna','horaDominical','festivaDiurna','festivaNocturna','recargos','minimolegal','auxilio')->get();

        foreach($factores as $f){
            $extraDiurna = $f->extraDiurna;
            $extraNocturna = $f->extraNocturna;
            $horaDominical = $f->horaDominical;
            $festivaDiurna = $f->festivaDiurna;
            $festivaNocturna = $f->festivaNocturna;
            $recargos = $f->recargos;
            $minimolegal = $f->minimolegal;
            $auxilio = $f->auxilio;
        }

        return ['extraDiurna' => $extraDiurna,
                'extraNocturna' => $extraNocturna,
                'horaDominical' => $horaDominical,
                'festivaDiurna' => $festivaDiurna,
                'festivaNocturna' => $festivaNocturna,
                'recargos' => $recargos,
                'minimolegal' => $minimolegal,
                'auxilio' => $auxilio
                ];
    }
    public function store(Request $request)
    {
        $tb_factores_nomina=new Tb_factores_nomina();
        $tb_factores_nomina->extraDiurna=$request->extraDiurna;
        $tb_factores_nomina->extraNocturna=$request->extraNocturna;
        $tb_factores_nomina->horaDominical=$request->horaDominical;
        $tb_factores_nomina->festivaDiurna=$request->festivaDiurna;
        $tb_factores_nomina->festivaNocturna=$request->festivaNocturna;
        $tb_factores_nomina->recargos=$request->recargos;
        $tb_factores_nomina->minimolegal=$request->minimolegal;
        $tb_factores_nomina->auxilio=$request->auxilio;
        $tb_factores_nomina->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_factores_nomina=Tb_factores_nomina::findOrFail($request->id);
        $tb_factores_nomina->extraDiurna=$request->extraDiurna;
        $tb_factores_nomina->extraNocturna=$request->extraNocturna;
        $tb_factores_nomina->horaDominical=$request->horaDominical;
        $tb_factores_nomina->festivaDiurna=$request->festivaDiurna;
        $tb_factores_nomina->festivaNocturna=$request->festivaNocturna;
        $tb_factores_nomina->recargos=$request->recargos;
        $tb_factores_nomina->minimolegal=$request->minimolegal;
        $tb_factores_nomina->auxilio=$request->auxilio;
        $tb_factores_nomina->save();
    }


    public function actualizar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_factores_nomina=Tb_factores_nomina::findOrFail($request->id);
        $tb_factores_nomina=Tb_factores_nomina::findOrFail($request->id);
        $tb_factores_nomina->extraDiurna=$request->extraDiurna;
        $tb_factores_nomina->extraNocturna=$request->extraNocturna;
        $tb_factores_nomina->horaDominical=$request->horaDominical;
        $tb_factores_nomina->festivaDiurna=$request->festivaDiurna;
        $tb_factores_nomina->festivaNocturna=$request->festivaNocturna;
        $tb_factores_nomina->recargos=$request->recargos;
        $tb_factores_nomina->minimolegal=$request->minimolegal;
        $tb_factores_nomina->auxilio=$request->auxilio;
        $tb_factores_nomina->save();
    }
}
