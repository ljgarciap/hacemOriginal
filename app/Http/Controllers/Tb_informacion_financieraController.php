<?php

namespace App\Http\Controllers;

use App\Tb_informacion_financiera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_informacion_financieraController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $financieras = Tb_informacion_financiera::where('estado','=','1')
        ->select('id','conceptoFinanciero','porcentaje')->orderBy('id','asc')->get();

        return ['financieras' => $financieras];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_informacion_financiera=new Tb_informacion_financiera();
        $tb_informacion_financiera->conceptoFinanciero=$request->conceptoFinanciero;
        $tb_informacion_financiera->porcentaje=$request->porcentaje;
        $tb_informacion_financiera->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_informacion_financiera=Tb_informacion_financiera::findOrFail($request->id);
        $tb_informacion_financiera->conceptoFinanciero=$request->conceptoFinanciero;
        $tb_informacion_financiera->porcentaje=$request->porcentaje;
        $tb_informacion_financiera->estado='1';
        $tb_informacion_financiera->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_informacion_financiera=Tb_informacion_financiera::findOrFail($request->id);
        $tb_informacion_financiera->estado='0';
        $tb_informacion_financiera->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_informacion_financiera=Tb_informacion_financiera::findOrFail($request->id);
        $tb_informacion_financiera->estado='1';
        $tb_informacion_financiera->save();
    }
}
