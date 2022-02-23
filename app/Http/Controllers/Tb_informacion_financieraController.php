<?php

namespace App\Http\Controllers;

use App\Tb_informacion_financiera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_informacion_financieraController extends Controller
{
    public function index()
    {
        //if(!$request->ajax()) return redirect('/');
        $financieras = Tb_informacion_financiera::where('id','=','1')
        ->select('id','vacaciones','prima','cesantias','intereses','salud','pension','arl','caja')->get();

        foreach($financieras as $totalg){
            $vacaciones = $totalg->vacaciones;
            $prima = $totalg->prima;
            $cesantias = $totalg->cesantias;
            $intereses = $totalg->intereses;
            $salud = $totalg->salud;
            $pension = $totalg->pension;
            $arl = $totalg->arl;
            $caja = $totalg->caja;
        }

        $liqui1=round(($vacaciones+$prima+$cesantias+$intereses), 2);
        $liqui=round((($liqui1/3)/100), 3);
        $paraf1=round(($salud+$pension+$arl+$caja), 2);
        $paraf=round((($paraf1/4)/100), 3);

        return ['vacaciones' => $vacaciones,
                'prima' => $prima,
                'cesantias' => $cesantias,
                'intereses' => $intereses,
                'salud' => $salud,
                'pension' => $pension,
                'arl' => $arl,
                'caja' => $caja,
                'liqui1' => $liqui1,
                'paraf1' => $paraf1,
                'liqui' => $liqui,
                'paraf' => $paraf
                ];
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_informacion_financiera=Tb_informacion_financiera::findOrFail($request->id);
        $tb_informacion_financiera->vacaciones=$request->vacaciones;
        $tb_informacion_financiera->prima=$request->prima;
        $tb_informacion_financiera->cesantias=$request->cesantias;
        $tb_informacion_financiera->intereses=$request->intereses;
        $tb_informacion_financiera->salud=$request->salud;
        $tb_informacion_financiera->pension=$request->pension;
        $tb_informacion_financiera->arl=$request->arl;
        $tb_informacion_financiera->caja=$request->caja;
        $tb_informacion_financiera->save();
    }


    public function actualizar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_informacion_financiera=Tb_informacion_financiera::findOrFail($request->id);
        $tb_informacion_financiera=Tb_informacion_financiera::findOrFail($request->id);
        $tb_informacion_financiera->vacaciones=$request->vacaciones;
        $tb_informacion_financiera->prima=$request->prima;
        $tb_informacion_financiera->cesantias=$request->cesantias;
        $tb_informacion_financiera->intereses=$request->intereses;
        $tb_informacion_financiera->salud=$request->salud;
        $tb_informacion_financiera->pension=$request->pension;
        $tb_informacion_financiera->arl=$request->arl;
        $tb_informacion_financiera->caja=$request->caja;
        $tb_informacion_financiera->save();
    }
}
