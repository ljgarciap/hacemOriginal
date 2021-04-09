<?php

namespace App\Http\Controllers;

use App\Tb_producto;
use App\Tb_kardex_producto_terminado;
use Illuminate\Http\Request;

class Tb_Kardex_Producto_TerminadoController extends Controller
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
            # Modelo::join('tablaqueseune',basicamente un on)
            $kardex = Tb_kardex_producto_terminado::join('tb_producto','tb_kardex_producto_terminado.idProducto','=','tb_producto.id')
            ->select('tb_kardex_producto_terminado.id','tb_kardex_producto_terminado.fecha',
            'tb_kardex_producto_terminado.detalle','tb_kardex_producto_terminado.cantidad','tb_kardex_producto_terminado.precio',
            'tb_kardex_producto_terminado.cantidadSaldos','tb_kardex_producto_terminado.precioSaldos','tb_kardex_producto_terminado.idProducto',
            'tb_kardex_producto_terminado.tipologia','tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto',
            'tb_producto.descripcion','tb_producto.estado')
            ->orderBy('tb_kardex_producto_terminado.id','desc')->paginate(5);
        }
        else {
            $kardex = Tb_kardex_producto_terminado::join('tb_producto','tb_kardex_producto_terminado.idProducto','=','tb_producto.id')
            ->select('tb_kardex_producto_terminado.id','tb_kardex_producto_terminado.fecha',
            'tb_kardex_producto_terminado.detalle','tb_kardex_producto_terminado.cantidad','tb_kardex_producto_terminado.precio',
            'tb_kardex_producto_terminado.cantidadSaldos','tb_kardex_producto_terminado.precioSaldos','tb_kardex_producto_terminado.idProducto',
            'tb_kardex_producto_terminado.tipologia','tb_producto.id','tb_producto.producto','tb_producto.referencia','tb_producto.foto',
            'tb_producto.descripcion','tb_producto.estado')
            ->where('tb_kardex_producto_terminado.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_kardex_producto_terminado.id','desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'         =>$kardex->total(),
                'current_page'  =>$kardex->currentPage(),
                'per_page'      =>$kardex->perPage(),
                'last_page'     =>$kardex->lastPage(),
                'from'          =>$kardex->firstItem(),
                'to'            =>$kardex->lastItem(),
            ],
            'kardex' =>  $kardex
        ];

    }

    public function store(Request $request)
    {
        $kw=$request;
        foreach($kw as $k){
            $cantidad=$k->cantidad;
            $precio=$k->precio;
            $cantidadSaldos= $k->cantidadSaldos;
            $precioSaldos=$k->precioSaldos;
        }

        $cantidadS=($cantidad-$cantidadSaldos);
        $precioS=($cantidad*$precio);

        //if(!$request->ajax()) return redirect('/');
        $tb_kardex_producto_terminado=new Tb_kardex_producto_terminado();
        $tb_kardex_producto_terminado->fecha=$request->fecha;
        $tb_kardex_producto_terminado->detalle=$request->detalle;
        $tb_kardex_producto_terminado->cantidad=$request->cantidad;
        $tb_kardex_producto_terminado->precio=$request->precio;
        $tb_kardex_producto_terminado->cantidadSaldos=$request->cantidadSaldos;
        $tb_kardex_producto_terminado->precioSaldos=$request->precioSaldos;
        $tb_kardex_producto_terminado->idProducto=$request->idProducto;
        $tb_kardex_producto_terminado->save();
    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $tb_kardex_producto_terminado=Tb_kardex_producto_terminado::findOrFail($request->id);
        $tb_kardex_producto_terminado->tipologia=1;
        $tb_kardex_producto_terminado->save();
    }

//---------------------Funcion para generar las relaciones en las tablas que quedan con los datos-----------------------------------//

    public function tipologia(Request $request)
        {
            //if(!$request->ajax()) return redirect('/');

            $idKardex_producto_terminado= $request->id;
            $tb_kardex_producto_terminado=Tb_kardex_producto_terminado::findOrFail($request->id);
            $tb_kardex_producto_terminado->tipologia=2;
            $tb_kardex_producto_terminado->save();

            $tb_kardex_producto_terminado2=Tb_kardex_producto_terminado::findOrFail($request->id);
            $fecha=$tb_kardex_producto_terminado->fecha;

        }

//---------------------------------------------------------------------------------------------------------------------------------//
}
