<?php

namespace App\Http\Controllers;

use App\Tb_concepto_cif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_concepto_cifController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $conceptos = Tb_concepto_cif::orderBy('id','desc')->paginate(5);
        }
        else {
            $conceptos = Tb_concepto_cif::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$conceptos->total(),
                'current_page'  =>$conceptos->currentPage(),
                'per_page'      =>$conceptos->perPage(),
                'last_page'     =>$conceptos->lastPage(),
                'from'          =>$conceptos->firstItem(),
                'to'            =>$conceptos->lastItem(),
            ],
                'conceptos' => $conceptos
        ];
    }

    public function selectConcepto(){
        $conceptos = Tb_concepto_cif::where('estado','=','1')
        ->select('id as idConcepto','concepto','valor')->orderBy('concepto','asc')->get();

        return ['conceptos' => $conceptos];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_concepto=new Tb_concepto_cif();
        $tb_concepto->concepto=$request->concepto;
        $tb_concepto->valor=$request->valor;
        $tb_concepto->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_concepto=Tb_concepto_cif::findOrFail($request->id);
        $tb_concepto->concepto=$request->concepto;
        $tb_concepto->valor=$request->valor;
        $tb_concepto->estado='1';
        $tb_concepto->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_concepto=Tb_concepto_cif::findOrFail($request->id);
        $tb_concepto->estado='0';
        $tb_concepto->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_concepto=Tb_concepto_cif::findOrFail($request->id);
        $tb_concepto->estado='1';
        $tb_concepto->save();
    }
}
