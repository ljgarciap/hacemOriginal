<?php

namespace App\Http\Controllers;

use App\Tb_vinculaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_vinculacionesController extends Controller
{
    //
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $areas = Tb_vinculaciones::orderBy('id','desc')->paginate(5);
        }
        else {
            $areas = Tb_vinculaciones::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$areas->total(),
                'current_page'  =>$areas->currentPage(),
                'per_page'      =>$areas->perPage(),
                'last_page'     =>$areas->lastPage(),
                'from'          =>$areas->firstItem(),
                'to'            =>$areas->lastItem(),
            ],
                'areas' => $areas
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_vinculaciones=new Tb_vinculaciones();
        $tb_vinculaciones->tipoContrato=$request->tipoContrato;
        $tb_vinculaciones->tipoSalario=$request->tipoSalario;
        $tb_vinculaciones->salarioBasicoMensual=$request->salarioBasicoMensual;
        $tb_vinculaciones->fechaInicio=$request->fechaInicio;
        $tb_vinculaciones->idEmpleado=$request->idEmpleado;
        $tb_vinculaciones->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_vinculaciones=Tb_vinculaciones::findOrFail($request->id);
        $tb_vinculaciones->tipoContrato=$request->tipoContrato;
        $tb_vinculaciones->tipoSalario=$request->tipoSalario;
        $tb_vinculaciones->salarioBasicoMensual=$request->salarioBasicoMensual;
        $tb_vinculaciones->fechaInicio=$request->fechaInicio;
        $tb_vinculaciones->idEmpleado=$request->idEmpleado;
        $tb_vinculaciones->estado='1';
        $tb_vinculaciones->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_vinculaciones=Tb_vinculaciones::findOrFail($request->id);
        $tb_vinculaciones->estado='0';
        $tb_vinculaciones->fechaFin=$request->fechaFin;
        $tb_vinculaciones->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_vinculaciones=Tb_vinculaciones::findOrFail($request->id);
        $tb_vinculaciones->estado='1';
        $tb_vinculaciones->fechaInicio=$request->fechaInicio;
        $tb_vinculaciones->save();
    }

}
