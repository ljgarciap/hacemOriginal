<?php

namespace App\Http\Controllers;

use App\Tb_rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_rolController extends Controller
{
    public function index()
    {
        $rol = Tb_rol::all();
        return view('rol.index', ['roles'=>$rol] );
    }

    public function create()
    {
        return view('rol.create');
    }

    public function store(Request $request)
    {

        //$datosMaterias = request()->all();
        $datosRoles =request()->except('_token');
        Tb_rol::insert($datosRoles);
        return redirect('rol');
    }

    public function edit($id)
    {
        $roles = Tb_rol::whereId($id)->firstOrFail();
        return view('rol.edit', compact('roles'));
    }

    public function update(Request $request, $id)
    {
        // Seteamos un nuevo titulo
            $datosRol=request()->except(['_token','_method']);
            Tb_rol::where('id','=',$id)->update($datosRol);
            // Guardamos en base de datos
            return redirect(action('Tb_rolController@index'));
    }

    public function deactivate($id)
    {
         $rol = DB::table('tb_rol')->find($id);
        if($rol->estado===1){
            Tb_rol::where('id','=',$id)->update(['estado' => 0]);
        }
        else{
            Tb_rol::where('id','=',$id)->update(['estado' => 1]);
        }
        return redirect(action('Tb_rolController@index'));
    }

    public function show($id)
    {
        //
    }
}
