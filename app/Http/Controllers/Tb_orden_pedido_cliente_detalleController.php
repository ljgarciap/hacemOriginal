<?php

namespace App\Http\Controllers;

use App\Tb_orden_pedido_cliente_detalle;
use App\Tb_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_orden_pedido_cliente_detalleController extends Controller
{
    //
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $identificador= $request->id;
            # Modelo::join('tablaqueseune',basicamente un on)
            $productos = Tb_orden_pedido_cliente_detalle::join('tb_producto','tb_orden_pedido_cliente_detalle.idProducto','=','tb_producto.id')
            ->select('tb_orden_pedido_cliente_detalle.id','tb_orden_pedido_cliente_detalle.idProducto','tb_orden_pedido_cliente_detalle.cantidad',
            'tb_orden_pedido_cliente_detalle.precioCosto','tb_orden_pedido_cliente_detalle.precioVenta','tb_orden_pedido_cliente_detalle.estado',
            'tb_producto.producto','tb_producto.referencia','tb_producto.descripcion','tb_producto.foto')
            ->where('tb_orden_pedido_cliente_detalle.idOrdenPedido', '=', $identificador)->get();
            return ['productos' => $productos];
    }

    public function posibles(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $identificador= $request->id;

        $posibles = DB::table('tb_producto')
        ->select('id as idProducto','producto')
        ->whereNotIn('id', DB::table('tb_orden_pedido_cliente_detalle')->select('idProducto')->where('idOrdenPedido', '=', $identificador))
        ->get();

        return ['posibles' => $posibles];
    }

    public function listar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;
        $identificador= $request->identificador;

        if ($buscar=='') {
            $productos = Tb_orden_pedido_cliente_detalle::join('tb_producto','tb_orden_pedido_cliente_detalle.idProducto','=','tb_producto.id')
            ->select('tb_orden_pedido_cliente_detalle.id','tb_orden_pedido_cliente_detalle.idProducto','tb_orden_pedido_cliente_detalle.cantidad',
            'tb_orden_pedido_cliente_detalle.precioCosto','tb_orden_pedido_cliente_detalle.precioVenta','tb_orden_pedido_cliente_detalle.estado',
            'tb_producto.producto','tb_producto.referencia','tb_producto.descripcion','tb_producto.foto')
            ->where('tb_orden_pedido_cliente_detalle.idOrdenPedido', '=', $identificador)
            ->orderBy('tb_rela_simulacion.id','desc')->paginate(5);
        }
        else if($criterio=='producto'){
            $productos = Tb_orden_pedido_cliente_detalle::join('tb_producto','tb_orden_pedido_cliente_detalle.idProducto','=','tb_producto.id')
            ->select('tb_orden_pedido_cliente_detalle.id','tb_orden_pedido_cliente_detalle.idProducto','tb_orden_pedido_cliente_detalle.cantidad',
            'tb_orden_pedido_cliente_detalle.precioCosto','tb_orden_pedido_cliente_detalle.precioVenta','tb_orden_pedido_cliente_detalle.estado',
            'tb_producto.producto','tb_producto.referencia','tb_producto.descripcion','tb_producto.foto')
            ->where([
                ['tb_producto.producto', 'like', '%'. $buscar . '%'],
                ['tb_orden_pedido_cliente_detalle.idOrdenPedido', '=', $identificador],
            ])
            ->orderBy('tb_orden_pedido_cliente_detalle.id','desc')->paginate(5);
        }
        else if($criterio=='referencia'){
            $productos = Tb_orden_pedido_cliente_detalle::join('tb_producto','tb_orden_pedido_cliente_detalle.idProducto','=','tb_producto.id')
            ->select('tb_orden_pedido_cliente_detalle.id','tb_orden_pedido_cliente_detalle.idProducto','tb_orden_pedido_cliente_detalle.cantidad',
            'tb_orden_pedido_cliente_detalle.precioCosto','tb_orden_pedido_cliente_detalle.precioVenta','tb_orden_pedido_cliente_detalle.estado',
            'tb_producto.producto','tb_producto.referencia','tb_producto.descripcion','tb_producto.foto')
            ->where([
                ['tb_producto.referencia', 'like', '%'. $buscar . '%'],
                ['tb_orden_pedido_cliente_detalle.idOrdenPedido', '=', $identificador],
            ])
            ->orderBy('tb_orden_pedido_cliente_detalle.id','desc')->paginate(5);
        }
        else {
            # code...
            $productos = Tb_orden_pedido_cliente_detalle::join('tb_producto','tb_orden_pedido_cliente_detalle.idProducto','=','tb_producto.id')
            ->select('tb_orden_pedido_cliente_detalle.id','tb_orden_pedido_cliente_detalle.idProducto','tb_orden_pedido_cliente_detalle.cantidad',
            'tb_orden_pedido_cliente_detalle.precioCosto','tb_orden_pedido_cliente_detalle.precioVenta','tb_orden_pedido_cliente_detalle.estado',
            'tb_producto.producto','tb_producto.referencia','tb_producto.descripcion','tb_producto.foto')
            ->where([
                ['tb_producto.id', 'like', '%'. $buscar . '%'],
                ['tb_orden_pedido_cliente_detalle.idOrdenPedido', '=', $identificador],
            ])
            ->orderBy('tb_orden_pedido_cliente_detalle.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$productos->total(),
                'current_page'  =>$productos->currentPage(),
                'per_page'      =>$productos->perPage(),
                'last_page'     =>$productos->lastPage(),
                'from'          =>$productos->firstItem(),
                'to'            =>$productos->lastItem(),
            ],
                'productos' => $productos
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_rela_simulacion=new Tb_orden_pedido_cliente_detalle();
        $tb_rela_simulacion->idProducto=$request->idProducto;
        $tb_rela_simulacion->cantidad=$request->cantidad;
        $tb_rela_simulacion->precioCosto=$request->precioCosto;
        $tb_rela_simulacion->precioVenta=$request->precioVenta;
        $tb_rela_simulacion->idOrdenPedido=$request->idOrdenPedido;
        $tb_rela_simulacion->save();
    }
}
