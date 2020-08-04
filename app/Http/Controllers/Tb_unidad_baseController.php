<?php

namespace App\Http\Controllers;

use App\Tb_unidad_base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_unidad_baseController extends Controller
{
    public function index()
    {
        $unidades = Tb_unidad_base::all();
        return view('unidad.index', ['unidades'=>$unidades] );
    }

    public function create()
    {
        return view('unidad.create');
    }

    public function store(Request $request)
    {

        //$datosMaterias = request()->all();
        $datosUnidades =request()->except('_token');
        Tb_unidad_base::insert($datosUnidades);
        //return response()->json($datosMaterias);
        return redirect('unidad');
    }

    public function edit($id)
    {
        $unidades = Tb_unidad_base::whereId($id)->firstOrFail();
        return view('unidad.edit', compact('unidades'));
    }

    public function update(Request $request, $id)
    {
        // Seteamos un nuevo titulo
            $datosUnidad=request()->except(['_token','_method']);
            Tb_unidad_base::where('id','=',$id)->update($datosUnidad);
            // Guardamos en base de datos
            return redirect(action('Tb_unidad_baseController@index'));
    }

    public function deactivate($id)
    {
         $unidad = DB::table('tb_unidad_base')->find($id);
        if($unidad->estado===1){
            Tb_unidad_base::where('id','=',$id)->update(['estado' => 0]);
        }
        else{
            Tb_unidad_base::where('id','=',$id)->update(['estado' => 1]);
        }
        return redirect(action('Tb_unidad_baseController@index'));
    }

    public function show($id)
    {
        //
    }
}
