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
            # Modelo::join('tablaqueseune',basicamente un on)
            $ordenes = Tb_orden_pedido_cliente::join('tb_clientes','tb_orden_pedido_cliente.idCliente','=','tb_clientes.id')
            ->select('tb_orden_pedido_cliente.id','tb_orden_pedido_cliente.consecutivo','tb_orden_pedido_cliente.fecha',
            'tb_orden_pedido_cliente.idCliente','tb_orden_pedido_cliente.observacion','tb_orden_pedido_cliente.estado',
            DB::raw('CONCAT(tb_clientes.nombre," ",tb_clientes.apellido," - ",tb_clientes.documento) as nombreCliente'))
            ->orderBy('tb_orden_pedido_cliente.consecutivo','asc')->paginate(5);
        }
        else {
            $ordenes = Tb_orden_pedido_cliente::join('tb_clientes','tb_orden_pedido_cliente.idCliente','=','tb_clientes.id')
            ->select('tb_orden_pedido_cliente.id','tb_orden_pedido_cliente.consecutivo','tb_orden_pedido_cliente.fecha',
            'tb_orden_pedido_cliente.idCliente','tb_orden_pedido_cliente.observacion','tb_orden_pedido_cliente.estado',
            DB::raw('CONCAT(tb_clientes.nombre," ",tb_clientes.apellido," - ",tb_clientes.documento) as nombreCliente'))
            ->orderBy('tb_orden_pedido_cliente.consecutivo','asc')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
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
        //if(!$request->ajax()) return redirect('/');

        $maximos = Tb_orden_pedido_cliente::select(DB::raw('MAX(tb_orden_pedido_cliente.consecutivo) as maximo'))
        ->get();

        $maximo=0;

        foreach($maximos as $maximo1){
            $maximosuma = $maximo1->consecutivo;
            $maximo=$maximo+$maximosuma;
            }

        if($maximo>1){$consecutivo=$maximo;}
        else {$consecutivo=1;}

        $tb_orden_pedido_cliente=new Tb_orden_pedido_cliente();
        $tb_orden_pedido_cliente->consecutivo=$consecutivo;
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
        // $clientes = Tb_cliente::all();
        $clientes = Tb_cliente::select('tb_clientes.id','tb_clientes.nombre','tb_clientes.apellido',
        'tb_clientes.documento','tb_clientes.direccion','tb_clientes.telefono','tb_clientes.correo',
        DB::raw('CONCAT(tb_clientes.nombre," ",tb_clientes.apellido," - ",tb_clientes.documento) as nombreCliente'))
        ->get();

        return ['clientes' => $clientes];
    }
}
