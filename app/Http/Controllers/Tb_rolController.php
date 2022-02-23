<?php

namespace App\Http\Controllers;

use App\Tb_rol;
use App\User;
use App\Tb_usuario_tiene_rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_rolController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $roles = Tb_rol::orderBy('id','desc')->paginate(5);
        }
        else {
            $roles = Tb_rol::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$roles->total(),
                'current_page'  =>$roles->currentPage(),
                'per_page'      =>$roles->perPage(),
                'last_page'     =>$roles->lastPage(),
                'from'          =>$roles->firstItem(),
                'to'            =>$roles->lastItem(),
            ],
                'roles' => $roles
        ];
    }

    public function selectRol(){
        $roles = Tb_rol::where('estado','=','1')
        ->select('id as idRol','rol')->orderBy('rol','asc')->get();
        return ['roles' => $roles];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_rol=new Tb_rol();
        $tb_rol->rol=$request->rol;
        $tb_rol->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_rol=Tb_rol::findOrFail($request->id);
        $tb_rol->rol=$request->rol;
        $tb_rol->estado='1';
        $tb_rol->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_rol=Tb_rol::findOrFail($request->id);
        $tb_rol->estado='0';
        $tb_rol->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_rol=Tb_rol::findOrFail($request->id);
        $tb_rol->estado='1';
        $tb_rol->save();
    }
}
