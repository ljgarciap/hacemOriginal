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

        return ['financieras' => $financieras];
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
