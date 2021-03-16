<?php

namespace App\Http\Controllers;

use App\Tb_cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_clienteController extends Controller
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
            $clientes = Tb_cliente::orderBy('id','desc')->paginate(5);
        }
        else {
            $cliente = Tb_cliente::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$clientes->total(),
                'current_page'  =>$clientes->currentPage(),
                'per_page'      =>$clientes->perPage(),
                'last_page'     =>$clientes->lastPage(),
                'from'          =>$clientes->firstItem(),
                'to'            =>$clientes->lastItem(),
            ],
                'clientes' => $clientes
        ];
    }

    public function selectCliente(){
        $clientes = Tb_cliente::where('estado','=','1')
        ->select('id as idCliente','cliente')->orderBy('cliente','asc')->get();

        return ['clientes' => $clientes];
    }

    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tb_cliente = new Tb_cliente();
        $tb_cliente->documento=$request->documento;
        $tb_cliente->nombre=$request->nombre;
        $tb_cliente->apellido=$request->apellido;
        $tb_cliente->direccion=$request->direccion;
        $tb_cliente->telefono=$request->telefono;
        $tb_cliente->correo=$request->correo;
        $tb_cliente->save();
    }

    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $tb_cliente = Tb_cliente::findOrFail($request->id);
        $tb_cliente->documento=$request->documento;
        $tb_cliente->nombre=$request->nombre;
        $tb_cliente->apellido=$request->apellido;
        $tb_cliente->direccion=$request->direccion;
        $tb_cliente->telefono=$request->telefono;
        $tb_cliente->correo=$request->correo;
        $tb_cliente->estado='1';
        $tb_cliente->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_cliente=Tb_cliente::findOrFail($request->id);
        $tb_cliente->estado='0';
        $tb_cliente->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_cliente=Tb_cliente::findOrFail($request->id);
        $tb_cliente->estado='1';
        $tb_cliente->save();
    }
}
