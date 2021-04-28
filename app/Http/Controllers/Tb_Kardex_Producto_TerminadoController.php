<?php

namespace App\Http\Controllers;
use App\Tb_kardex_producto_terminado;
use App\Tb_producto;
use App\Tb_orden_produccion;
use App\Tb_orden_produccion_detalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Tb_kardex_producto_terminadoController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $kardex = Tb_kardex_producto_terminado::join('tb_producto','tb_kardex_producto_terminado.idProducto','=','tb_producto.id')
            ->select('tb_kardex_producto_terminado.id','tb_kardex_producto_terminado.fecha','tb_kardex_producto_terminado.detalle','tb_kardex_producto_terminado.cantidad',
            'tb_kardex_producto_terminado.precio','tb_kardex_producto_terminado.cantidadSaldos','tb_kardex_producto_terminado.precioSaldos','tb_kardex_producto_terminado.idProducto',
            'tb_kardex_producto_terminado.tipologia','tb_producto.producto as producto','tb_producto.estado',
            DB::raw('tb_kardex_producto_terminado.cantidadSaldos * tb_kardex_producto_terminado.precioSaldos as saldos'))
            ->orderBy('tb_kardex_producto_terminado.idProducto','asc')
            ->whereIn('tb_kardex_producto_terminado.id', function($sub){$sub->selectRaw('max(id)')->from('tb_kardex_producto_terminado')->groupBy('idProducto');})
            ->paginate(5);
        }
        else {
            $kardex = Tb_kardex_producto_terminado::join('tb_producto','tb_kardex_producto_terminado.idProducto','=','tb_producto.id')
            ->select('tb_kardex_producto_terminado.id','tb_kardex_producto_terminado.fecha','tb_kardex_producto_terminado.detalle','tb_kardex_producto_terminado.cantidad',
            'tb_kardex_producto_terminado.precio','tb_kardex_producto_terminado.cantidadSaldos','tb_kardex_producto_terminado.precioSaldos','tb_kardex_producto_terminado.idProducto',
            'tb_kardex_producto_terminado.tipologia','tb_producto.producto as producto','tb_producto.estado',
            DB::raw('tb_kardex_producto_terminado.cantidadSaldos * tb_kardex_producto_terminado.precioSaldos as saldos'))
            ->whereIn('tb_kardex_producto_terminado.id', function($sub){$sub->selectRaw('max(id)')->from('tb_kardex_producto_terminado')->groupBy('idProducto');})
            ->where('tb_kardex_producto_terminado.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_kardex_producto_terminado.idProducto','asc')->paginate(5);
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

    public function listar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $identificador= $request->identificador;

 /**/
            $kardex = Tb_kardex_producto_terminado::join('tb_producto','tb_kardex_producto_terminado.idProducto','=','tb_producto.id')
            ->select('tb_kardex_producto_terminado.id as idKardex','tb_kardex_producto_terminado.fecha','tb_kardex_producto_terminado.detalle','tb_kardex_producto_terminado.cantidad',
            'tb_kardex_producto_terminado.precio',DB::raw('tb_kardex_producto_terminado.cantidad * tb_kardex_producto_terminado.precio as preciototal'),
            'tb_kardex_producto_terminado.cantidadSaldos','tb_kardex_producto_terminado.precioSaldos','tb_kardex_producto_terminado.idProducto',
            'tb_kardex_producto_terminado.tipologia','tb_producto.producto as producto','tb_producto.estado',
            DB::raw('tb_kardex_producto_terminado.cantidadSaldos * tb_kardex_producto_terminado.precioSaldos as totalsaldos'))
            ->where('tb_kardex_producto_terminado.idProducto', '=', $identificador)
            ->orderBy('tb_kardex_producto_terminado.id','asc')->paginate(5);

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
    public function general()
    {
        //if(!$request->ajax()) return redirect('/');
        $materias = Tb_producto::where('estado','=','1')
            ->select('tb_producto.id as idProducto','tb_producto.producto as producto')
            ->get();

        return ['materias' =>  $materias];
    }
    public function ordenes() //PARA TRAER DATOS ACORDE
    {
        //if(!$request->ajax()) return redirect('/');
        $ordenes = DB::table('tb_orden_produccion')
        ->select('tb_orden_produccion.id','tb_orden_produccion.consecutivo','tb_orden_produccion.fecha')
        ->whereIn('tb_orden_produccion.id', function($sub){$sub->selectRaw('max(id)')->from('tb_orden_produccion')->groupBy('consecutivo');})
        ->orderBy('tb_orden_produccion.id','desc')
        ->get();

        return ['ordenes' =>  $ordenes];

    }
    public function material($identificador) //PARA TRAER DATOS ACORDE
    {
        //if(!$request->ajax()) return redirect('/');
        $materiales = Tb_orden_produccion::join('tb_producto','tb_orden_produccion.idProducto','=','tb_producto.id')
            ->select('tb_producto.producto as producto','tb_producto.id')
            ->where('tb_orden_produccion.idOrdenPedido', '=', $identificador)
            ->orderBy('tb_producto.id','asc')
            ->get();

        return ['materiales' =>  $materiales];

    }
    public function factura(Request $request) //PARA TRAER DATOS ACORDE
    {
        //if(!$request->ajax()) return redirect('/');
        $proveedor=$request->proveedor;
        $materiales = Tb_kardex_producto_terminado::join('tb_proveedores','tb_kardex_producto_terminado.observaciones','=','tb_proveedores.id')
            ->select('tb_kardex_producto_terminado.id','tb_kardex_producto_terminado.detalle as factura','tb_proveedores.razonSocial as proveedor',
            DB::raw("CONCAT('Factura: ',tb_kardex_producto_terminado.detalle,' - ',tb_proveedores.razonSocial) AS detallado"))
            ->where([
                ['tb_kardex_producto_terminado.idDocumentos', '=', '1'],
                ['tb_kardex_producto_terminado.tipologia', '=', '1'],
                ['tb_kardex_producto_terminado.observaciones', '=', $proveedor],
            ])
            ->whereIn('tb_kardex_producto_terminado.id', function($sub){$sub->selectRaw('max(id)')->from('tb_kardex_producto_terminado')->groupBy('tb_kardex_producto_terminado.detalle');})
            ->orderBy('tb_kardex_producto_terminado.detalle','asc')
            ->get();

        return ['materiales' =>  $materiales];

    }
    public function materialfactura(Request $request) //PARA TRAER DATOS ACORDE
    {
        //if(!$request->ajax()) return redirect('/');
        $kardexes=$request->factura;
        $registros = DB::table('tb_kardex_producto_terminado')->where('id', '=', $kardexes)->get();

        foreach ($registros as $registro) {
            $factura = $registro->detalle;
            $proveedor = $registro->observaciones;
        }

        $materiales = Tb_kardex_producto_terminado::join('tb_producto','tb_kardex_producto_terminado.idProducto','=','tb_producto.id')
            ->select('tb_kardex_producto_terminado.idProducto','tb_producto.producto as producto','tb_producto.id')
            ->distinct('tb_kardex_producto_terminado.idProducto')
            ->where([
                ['tb_kardex_producto_terminado.idDocumentos', '=', '1'],
                ['tb_kardex_producto_terminado.tipologia', '=', '1'],
                ['tb_kardex_producto_terminado.detalle', '=', $factura],
                ['tb_kardex_producto_terminado.observaciones', '=', $proveedor],
            ])
            ->orderBy('tb_producto.id','asc')
            ->get();

        return ['materiales' =>  $materiales];

    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $fecha=$request->fecha;
        $detalle=$request->detalle;
        $cantidad=$request->cantidad;
        $precio=$request->precio;
        $idProducto=$request->idProducto;
        $observaciones=$request->observaciones;
        $idDocumentos=$request->idDocumentos;
        $tipologia=$request->tipologia;
        $valorE=($precio*$cantidad);

        //capturo cantidad precio y producto; internamente busco el registro mas reciente de dicho producto y tomo el valor cantidad de ese registro,
        //ahora, miro los datos del ingreso nuevo, si es un 1 es un ingreso y sumo la nueva cantidad a la de cantidadSaldos del registro anterior,
        //si es 2 es una salida y lo que hago es restar la nueva cantidad de la de cantidadSaldos del registro anterior; el resultado va en el
        //registro nuevo en el campo cantidadSaldos; ahora para llenar el campo de precioSaldos (que es el precio promedio) lo que hago es del registro
        //anterior multiplico cantidadSaldos*precioSaldos y a ese valor le sumo o resto segun el caso el valor del registro nuevo que resulta de
        //cantidad*precio; el resultado lo divido entre el valor que calcule de cantidadSaldos y lo ingreso en precioSaldos; hay que tener muy en
        //cuenta que en el primer registro las cantidad y cantidadSaldos asi como las precio y precioSaldos son identicas.
        //Proceso para calculo de kardex

        $precioSaldos = DB::table('tb_kardex_producto_terminado')
        ->select('id','cantidad as cantidadA','cantidadSaldos as cantidadS','precioSaldos as precioS')
        ->where('tb_kardex_producto_terminado.idProducto','=', $idProducto)
        ->orderByDesc('id')
        ->limit(1)
        ->get();

        $precioSaldoscant= DB::table('tb_kardex_producto_terminado')
        ->where('tb_kardex_producto_terminado.idProducto','=', $idProducto)
        ->count();

        if (!$precioSaldoscant) {
            $suma1=$cantidad;
            $suma2=$precio;
        }
        else{
            foreach($precioSaldos as $precioS){
                $cantidadA = $precioS->cantidadA;
                $cantidadS = $precioS->cantidadS;
                $precioSA = $precioS->precioS;
                $valorP=($cantidadS*$precioSA);
            }
            if($tipologia == 1){
            $suma1=$cantidadS+$cantidad;
            $suma0=$valorP+$valorE;
            $suma2=($suma0/$suma1);
            }
            else{
                $suma1=$cantidadS-$cantidad;
                $suma0=$valorP-$valorE;
                $suma2=($suma0/$suma1);
            }
        }

        $tb_kardex_producto_terminado=new Tb_kardex_producto_terminado();
        $tb_kardex_producto_terminado->detalle=$detalle;
        $tb_kardex_producto_terminado->cantidad=$cantidad;
        $tb_kardex_producto_terminado->precio=$precio;
        $tb_kardex_producto_terminado->idProducto=$idProducto;
        $tb_kardex_producto_terminado->observaciones=$observaciones;
        $tb_kardex_producto_terminado->idDocumentos=$idDocumentos;
        $tb_kardex_producto_terminado->tipologia=$tipologia;
        $tb_kardex_producto_terminado->fecha=$fecha;
        $tb_kardex_producto_terminado->cantidadSaldos=$suma1;
        $tb_kardex_producto_terminado->precioSaldos=$suma2;
        $tb_kardex_producto_terminado->save();
    }
}
