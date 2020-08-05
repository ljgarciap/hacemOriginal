<?php

namespace App\Http\Controllers;

use App\Tb_tipo_materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_tipo_materiaController extends Controller
{
    public function index()
    {
        $tipomateria = Tb_tipo_materia::all();
        return view('tipomateria.index', ['tipomaterias'=>$tipomateria] );
    }

    public function create()
    {
        return view('tipomateria.create');
    }

    public function store(Request $request)
    {

        //$datosMaterias = request()->all();
        $datostipomateria =request()->except('_token');
        Tb_tipo_materia::insert($datostipomateria);
        //return response()->json($datosMaterias);
        return redirect('tipomateria');
    }

    public function edit($id)
    {
        $tipomaterias = Tb_tipo_materia::whereId($id)->firstOrFail();
        return view('tipomateria.edit', compact('tipomaterias'));
    }

    public function update(Request $request, $id)
    {
        // Seteamos un nuevo titulo
            $datostipomateria=request()->except(['_token','_method']);
            Tb_tipo_materia::where('id','=',$id)->update($datostipomateria);
            // Guardamos en base de datos
            return redirect(action('Tb_tipo_materiaController@index'));
    }

    public function deactivate($id)
    {
         $unidad = DB::table('tb_tipo_materia')->find($id);
        if($unidad->estado===1){
            Tb_tipo_materia::where('id','=',$id)->update(['estado' => 0]);
        }
        else{
            Tb_tipo_materia::where('id','=',$id)->update(['estado' => 1]);
        }
        return redirect(action('Tb_tipo_materiaController@index'));
    }

    public function show($id)
    {
        //
    }
}
