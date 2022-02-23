<?php

namespace App\Http\Controllers;

use App\Tb_coleccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_coleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $colecciones = Tb_coleccion::orderBy('id','desc')->paginate(5);
        }
        else {
            $colecciones = Tb_coleccion::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$colecciones->total(),
                'current_page'  =>$colecciones->currentPage(),
                'per_page'      =>$colecciones->perPage(),
                'last_page'     =>$colecciones->lastPage(),
                'from'          =>$colecciones->firstItem(),
                'to'            =>$colecciones->lastItem(),
            ],
                'colecciones' => $colecciones
        ];
    }

    public function selectColeccion(){
        $colecciones = Tb_coleccion::where('estado','=','1')
        ->select('id as idColeccion','coleccion')->orderBy('coleccion','asc')->get();

        return ['colecciones' => $colecciones];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_coleccion=new Tb_coleccion();
        $tb_coleccion->coleccion=$request->coleccion;
        $tb_coleccion->referencia=$request->referencia;
        $tb_coleccion->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_coleccion=Tb_coleccion::findOrFail($request->id);
        $tb_coleccion->coleccion=$request->coleccion;
        $tb_coleccion->referencia=$request->referencia;
        $tb_coleccion->estado='1';
        $tb_coleccion->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_coleccion=Tb_coleccion::findOrFail($request->id);
        $tb_coleccion->estado='0';
        $tb_coleccion->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_coleccion=Tb_coleccion::findOrFail($request->id);
        $tb_coleccion->estado='1';
        $tb_coleccion->save();
    }
}
