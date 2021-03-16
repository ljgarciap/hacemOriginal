<?php

namespace App\Http\Controllers;


use App\Tb_perfil;
use App\Tb_empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_empleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $empleados = Tb_empleado::join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
            ->select('tb_empleado.id','tb_empleado.documento','tb_empleado.nombre','tb_empleado.apellido','tb_empleado.direccion',
            'tb_empleado.telefono','tb_empleado.correo','tb_empledo.estado','tb_perfil.id as idPerfil','tb_perfil.perfil',
            'tb_perfil.estado as estado_perfil')
            ->orderBy('tb_empleado.id','desc')->paginate(5);
        }
        else if($criterio=='perfil'){
            $empleados = Tb_empleado::join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
            ->select('tb_empleado.id','tb_empleado.documento','tb_empleado.nombre','tb_empleado.apellido','tb_empleado.direccion',
            'tb_empleado.telefono','tb_empleado.correo','tb_empledo.estado','tb_perfil.id as idPerfil','tb_perfil.perfil',
            'tb_perfil.estado as estado_perfil')
            ->where('tb_perfil.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_empleado.id','desc')->paginate(5);
        }
        else {
            # code...
            $empleados = Tb_empleado::join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
            ->select('tb_empleado.id','tb_empleado.documento','tb_empleado.nombre','tb_empleado.apellido','tb_empleado.direccion',
            'tb_empleado.telefono','tb_empleado.correo','tb_empledo.estado','tb_perfil.id as idPerfil','tb_perfil.perfil',
            'tb_perfil.estado as estado_perfil')
            ->where('tb_empleado.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_empleado.id','desc')->paginate(5);

        }

        return [
            'pagination' => [
                'total'         =>$empleados->total(),
                'current_page'  =>$empleados->currentPage(),
                'per_page'      =>$empleados->perPage(),
                'last_page'     =>$empleados->lastPage(),
                'from'          =>$empleados->firstItem(),
                'to'            =>$empleados->lastItem(),
            ],
                'empleados' => $empleados
        ];
    }
    public function selectEmpleado(){
        $empleados = Tb_empleado::where('estado','=','1')
        ->select('id as idEmpleado','empleado')->orderBy('empleado','asc')->get();

        return ['empleados' => $empleados];
    }
    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tb_empleado = new Tb_empleado();
        $tb_empleado->documento=$request->documento;
        $tb_empleado->idPerfil=$request->idPerfil;
        $tb_empleado->nombre=$request->nombre;
        $tb_empleado->apellido=$request->apellido;
        $tb_empleado->direccion=$request->direccion;
        $tb_empleado->telefono=$request->telefono;
        $tb_empleado->correo=$request->correo;
        $tb_empleado->save();
    }

    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tb_empleado =Tb_empleado::findOrFail($request->id);
        $tb_empleado->documento=$request->documento;
        $tb_empleado->idPerfil=$request->idPerfil;
        $tb_empleado->nombre=$request->nombre;
        $tb_empleado->apellido=$request->apellido;
        $tb_empleado->direccion=$request->direccion;
        $tb_empleado->telefono=$request->telefono;
        $tb_empleado->correo=$request->correo;
        $tb_empleado->estado='1';
        $tb_empleado->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_empleado=Tb_empleado::findOrFail($request->id);
        $tb_empleado->estado='0';
        $tb_empleado->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_empleado=Tb_empleado::findOrFail($request->id);
        $tb_empleado->estado='1';
        $tb_empleado->save();
    }
}
