<?php

namespace App\Http\Controllers;

use App\User;
use App\Tb_rol;
use App\Tb_usuario_tiene_rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
            ->leftJoin('tb_rol',function($join){
                $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
            })
            ->select('users.id','users.name','users.email','users.estado','tb_rol.id as id_rol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as id_tb_usuario_tiene_rol')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='name'){
            # code...
            $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
            ->leftJoin('tb_rol',function($join){
                $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
            })
            ->select('users.id','users.name','users.email','users.estado','tb_rol.id as id_rol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as id_tb_usuario_tiene_rol')
            ->where('users.name', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='rol'){
            # code...
            $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
            ->leftJoin('tb_rol',function($join){
                $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
            })
            ->select('users.id','users.name','users.email','users.estado','tb_rol.id as id_rol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as id_tb_usuario_tiene_rol')
            ->where('tb_rol.rol', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='email'){
            # code...
            $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
            ->leftJoin('tb_rol',function($join){
                $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
            })
            ->select('users.id','users.name','users.email','users.estado','tb_rol.id as id_rol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as id_tb_usuario_tiene_rol')
            ->where('users.email', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else {
                # code...
                $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
                ->leftJoin('tb_rol',function($join){
                    $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
                })
                ->select('users.id','users.name','users.email','users.estado','tb_rol.id as id_rol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as id_tb_usuario_tiene_rol')
                ->where('users.id', 'like', '%'. $buscar . '%')
                ->orderBy('users.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$usuarios->total(),
                'current_page'  =>$usuarios->currentPage(),
                'per_page'      =>$usuarios->perPage(),
                'last_page'     =>$usuarios->lastPage(),
                'from'          =>$usuarios->firstItem(),
                'to'            =>$usuarios->lastItem(),
            ],
                'usuarios' => $usuarios
        ];
    }
//voy aca
    public function selectRelacion(Request $request){
        //if(!$request->ajax()) return redirect('/'); ajustar con cuidado
        /*        */
        $roles = DB::table('tb_rol')
                   ->select('id as id_rol','rol')
                   ->where('estado','=','1');

        $relaciones = DB::table('users')
                ->joinSub($roles, 'tb_proceso', function ($join) {
                    $join->on('tb_area.id', '=', 'tb_proceso.idArea');
                })
                ->select('id as id_area','id_proceso','proceso')
                ->where('estado', '=', '1')
                ->get();

                return ['relaciones' => $relaciones];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $users=new User();
        $users->name=$request->name;
        $users->idRol=$request->idRol;
        $users->email=$request->email;
        $users->password=bcrypt($request->email);
        $users->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $users=User::findOrFail($request->id);
        $users->name=$request->name;
        $users->idRol=$request->idRol;
        $users->email=$request->email;
        $users->estado='1';
        $users->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $users=User::findOrFail($request->id);
        $users->estado='0';
        $users->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $users=User::findOrFail($request->id);
        $users->estado='1';
        $users->save();
    }

}
