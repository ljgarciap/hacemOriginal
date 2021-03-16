<?php

namespace App\Http\Controllers;

use App\Tb_materia_prima_producto;
use App\Tb_gestion_materia_prima;
use App\tb_hoja_de_costo;
use App\Tb_producto;
use App\Tb_cliente;
use App\Tb_orden_pedido_cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_orden_pedido_clienteController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $ordenes = Tb_orden_pedido_cliente::orderBy('id','desc')->paginate(5);
        }
        else {
            $ordenes = Tb_orden_pedido_cliente::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$ordenes->total(),
                'current_page'  =>$ordenes->currentPage(),
                'per_page'      =>$ordenes->perPage(),
                'last_page'     =>$ordenes->lastPage(),
                'from'          =>$ordenes->firstItem(),
                'to'            =>$ordenes->lastItem(),
            ],
                'ordenes' => $ordenes
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_orden_pedido_cliente=new Tb_orden_pedido_cliente();
        $tb_orden_pedido_cliente->fecha=$request->fecha;
        $tb_orden_pedido_cliente->idCliente=$request->idCliente;
        $tb_orden_pedido_cliente->observacion=$request->observacion;
        $tb_orden_pedido_cliente->save();
    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_orden_pedido_cliente=Tb_orden_pedido_cliente::findOrFail($request->id);
        $tb_orden_pedido_cliente->estado=1;
        $tb_orden_pedido_cliente->save();
    }

    public function clientes()
    {
        //
       $clientes = Tb_cliente::all();
        return ['clientes' => $clientes];
    }
}
