<?php

namespace App\Http\Controllers;
use App\Tb_producto;
use App\Tb_kardex_producto_terminado;
use Illuminate\Support\Facades\DB;
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
             ->select('tb_kardex_producto_terminado.id','tb_kardex_producto_terminado.fecha','tb_kardex_producto_terminado.detalle','tb_kardex_producto_terminado.cantidad',
             'tb_kardex_producto_terminado.precio','tb_kardex_producto_terminado.cantidadSaldos','tb_kardex_producto_terminado.precioSaldos',
             'tb_kardex_producto_terminado.tipologia','tb_producto.id as idProducto','tb_producto.producto',
            DB::raw('tb_kardex_producto_terminado.cantidadSaldos * tb_kardex_producto_terminado.precioSaldos as saldos'))
             ->paginate(5);
         }
         else {
             $kardex = Tb_kardex_producto_terminado::join('tb_producto','tb_kardex_producto_terminado.idProducto','=','tb_producto.id')
             ->select(Tb_kardex_producto_terminado::raw('tb_kardex_producto_terminado.cantidadSaldos * tb_kardex_producto_terminado.precioSaldos as saldos,
             tb_kardex_producto_terminado.id,tb_kardex_producto_terminado.fecha,tb_kardex_producto_terminado.detalle,tb_kardex_producto_terminado.cantidad,
             tb_kardex_producto_terminado.precio,tb_kardex_producto_terminado.cantidadSaldos,tb_kardex_producto_terminado.precioSaldos,tb_kardex_producto_terminado.idProducto,
             tb_kardex_producto_terminado.tipologia,tb_producto.id as idProducto,tb_producto.producto'))
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
    public function prueba(Request $request)
    {
            $kardex1 = DB::table('tb_kardex_producto_terminado')
            ->get()
            ->paginate(5);
            $kardex = $kardex1->groupBy('idProducto');

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
    public function ultimoRegistro(){
        $kardex = DB::table('tb_kardex_producto_terminado')
        ->orderByDesc('id')
        ->limit(1)->get();
        return ['kardex' => $kardex];
    }
    public function store(Request $request)
    {
        //capturo cantidad precio,producto y tipologia; internamente busco el registro mas reciente de dicho producto y tomo el valor cantidad de ese registro,
        //ahora, miro los datos del ingreso nuevo, si es un 1 es un ingreso y sumo la nueva cantidad a la de cantidadSaldos del registro anterior,
        //si es 2 es una salida y lo que hago es restar la nueva cantidad de la de cantidadSaldos del registro anterior; el resultado va en el
        //registro nuevo en el campo cantidadSaldos; ahora para llenar el campo de precioSaldos (que es el precio promedio) lo que hago es del registro
        //anterior multiplico cantidadSaldos*precioSaldos y a ese valor le sumo o resto segun el caso el valor del registro nuevo que resulta de
        //cantidad*precio; el resultado lo divido entre el valor que calcule de cantidadSaldos y lo ingreso en precioSaldos; hay que tener muy en
        //cuenta que en el primer registro las cantidad y cantidadSaldos asi como las precio y precioSaldos son identicas.        

            //si el producto es tipo=1 es entrada o si es tipo=2 salida

        if(!$request->ajax()) return redirect('/');
        $cantidadSaldos = DB::table('tb_kardex_producto_terminado')
        ->select('cantidadSaldos')
        /*->where('id','=','1')*/
        ->orderByDesc('id')
        ->limit(1)
        ->get();
        
        $precioSaldos = DB::table('tb_kardex_producto_terminado')
        ->select('precioSaldos')
        ->orderByDesc('id')
        ->limit(1)
        ->get(); 
        if($kardex->tipologia == 1){
        $saldo1->cantidadSaldos=$request->cantidadSaldos;
        $saldo2->precioSaldos=$request->precioSaldos;
        $suma1=$saldo1+$cantidadSaldos;
        $suma2=$saldo2+$precioSaldos;
        }   

        $tb_kardex_producto_terminado=new Tb_kardex_producto_terminado();
        $tb_kardex_producto_terminado->fecha=$request->fecha;
        $tb_kardex_producto_terminado->detalle=$request->detalle;
        $tb_kardex_producto_terminado->cantidad=$request->cantidad;
        $tb_kardex_producto_terminado->precio=$request->precio;
        $tb_kardex_producto_terminado->cantidadSaldos=$suma1;
        $tb_kardex_producto_terminado->precioSaldos=$suma2;
        $tb_kardex_producto_terminado->idProducto=$request->idProducto;
        $tb_kardex_producto_terminado->tipologia=$request->tipologia;
        $tb_kardex_producto_terminado->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_kardex_producto_terminado=Tb_kardex_producto_terminado::findOrFail($request->id);
        $tb_kardex_producto_terminado->fecha=$request->fecha;
        $tb_kardex_producto_terminado->detalle=$request->detalle;
        $tb_kardex_producto_terminado->cantidad=$request->cantidad;
        $tb_kardex_producto_terminado->precio=$request->precio;
        $tb_kardex_producto_terminado->cantidadSaldos=$request->cantidadSaldos;
        $tb_kardex_producto_terminado->precioSaldos=$request->precioSaldos;
        $tb_kardex_producto_terminado->idProducto=$request->idProducto;
        $tb_kardex_producto_terminado->save();
    }
}
