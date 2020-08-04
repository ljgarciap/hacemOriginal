<?php

namespace App\Http\Controllers;

use App\Tb_area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_areaController extends Controller
{
    public function index()
    {
        $areas = Tb_area::all();
        return view('area.index', ['areas'=>$areas] );
    }

    public function create()
    {
        return view('area.create');
    }

    public function store(Request $request)
    {

        //$datosMaterias = request()->all();
        $datosAreas =request()->except('_token');
        Tb_area::insert($datosAreas);
        //return response()->json($datosMaterias);
        return redirect('area');
    }

    public function edit($id)
    {
        $areas = Tb_area::whereId($id)->firstOrFail();
        return view('area.edit', compact('areas'));
    }

    public function update(Request $request, $id)
    {
        // Seteamos un nuevo titulo
            $datosArea=request()->except(['_token','_method']);
            Tb_area::where('id','=',$id)->update($datosArea);
            // Guardamos en base de datos
            return redirect(action('Tb_areaController@index'));
    }

    public function deactivate($id)
    {
         $user = DB::table('tb_area')->find($id);
        if($user->estado===1){
            Tb_area::where('id','=',$id)->update(['estado' => 0]);
        }
        else{
            Tb_area::where('id','=',$id)->update(['estado' => 1]);
        }
        return redirect(action('Tb_areaController@index'));
    }

    public function show($id)
    {
        //
    }
}
