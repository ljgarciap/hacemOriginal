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
        ->select('id','extraDiurna','extraNocturna','horaDominical','festivaDiurna','festivaNocturna')->get();

        foreach($factores as $f){
            $extraDiurna = $f->extraDiurna;
            $extraNocturna = $f->extraNocturna;
            $horaDominical = $f->horaDominical;
            $festivaDiurna = $f->festivaDiurna;
            $festivaNocturna = $f->festivaNocturna;
        }

        return ['extraDiurna' => $extraDiurna,
                'extraNocturna' => $extraNocturna,
                'horaDominical' => $horaDominical,
                'festivaDiurna' => $festivaDiurna,
                'festivaNocturna' => $festivaNocturna
                ];
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
        $tb_factores_nomina->save();
    }
}
