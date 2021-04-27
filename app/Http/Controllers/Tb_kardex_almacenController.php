<?php

namespace App\Http\Controllers;
use App\Tb_kardex_almacen;
use App\Tb_gestion_materia_prima;
use App\Tb_orden_produccion;
use App\Tb_orden_produccion_detalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Tb_kardex_almacenController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $productos = Tb_kardex_almacen::join('tb_gestion_materia_prima','tb_kardex_almacen.idGestionMateria','=','tb_gestion_materia_prima.id')
            ->select('tb_kardex_almacen.id','tb_kardex_almacen.fecha','tb_kardex_almacen.detalle','tb_kardex_almacen.cantidad',
            'tb_kardex_almacen.precio','tb_kardex_almacen.cantidadSaldos','tb_kardex_almacen.precioSaldos','tb_kardex_almacen.idGestionMateria',
            'tb_kardex_almacen.tipologia','tb_gestion_materia_prima.gestionMateria as producto','tb_gestion_materia_prima.idUnidadBase',
            'tb_gestion_materia_prima.estado',DB::raw('tb_kardex_almacen.cantidadSaldos * tb_kardex_almacen.precioSaldos as saldos'))
            ->orderBy('tb_kardex_almacen.idGestionMateria','asc')
            ->whereIn('tb_kardex_almacen.id', function($sub){$sub->selectRaw('max(id)')->from('tb_kardex_almacen')->groupBy('idGestionMateria');})
            ->paginate(5);
        }
        else {
            $productos = Tb_kardex_almacen::join('tb_gestion_materia_prima','tb_kardex_almacen.idGestionMateria','=','tb_gestion_materia_prima.id')
            ->select('tb_kardex_almacen.id','tb_kardex_almacen.fecha','tb_kardex_almacen.detalle','tb_kardex_almacen.cantidad',
            'tb_kardex_almacen.precio','tb_kardex_almacen.cantidadSaldos','tb_kardex_almacen.precioSaldos','tb_kardex_almacen.idGestionMateria',
            'tb_kardex_almacen.tipologia','tb_gestion_materia_prima.gestionMateria as producto','tb_gestion_materia_prima.idUnidadBase',
            'tb_gestion_materia_prima.estado',DB::raw('tb_kardex_almacen.cantidadSaldos * tb_kardex_almacen.precioSaldos as saldos'))
            ->whereIn('tb_kardex_almacen.id', function($sub){$sub->selectRaw('max(id)')->from('tb_kardex_almacen')->groupBy('idGestionMateria');})
            ->where('tb_kardex_almacen.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_kardex_almacen.idGestionMateria','asc')->paginate(5);
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
            'productos' =>  $productos
        ];

    }

    public function listar(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $identificador= $request->identificador;

 /**/
            $productos = Tb_kardex_almacen::join('tb_gestion_materia_prima','tb_kardex_almacen.idGestionMateria','=','tb_gestion_materia_prima.id')
            ->select('tb_kardex_almacen.id as idMateria','tb_kardex_almacen.fecha','tb_kardex_almacen.detalle','tb_kardex_almacen.cantidad',
            'tb_kardex_almacen.precio',DB::raw('tb_kardex_almacen.cantidad * tb_kardex_almacen.precio as preciototal'),
            'tb_kardex_almacen.cantidadSaldos','tb_kardex_almacen.precioSaldos','tb_kardex_almacen.idGestionMateria',
            'tb_kardex_almacen.tipologia','tb_gestion_materia_prima.gestionMateria as producto','tb_gestion_materia_prima.idUnidadBase',
            'tb_gestion_materia_prima.estado',DB::raw('tb_kardex_almacen.cantidadSaldos * tb_kardex_almacen.precioSaldos as totalsaldos'))
            ->where('tb_kardex_almacen.idGestionMateria', '=', $identificador)
            ->orderBy('tb_kardex_almacen.id','asc')->paginate(5);

        return [
            'pagination' => [
                'total'         =>$productos->total(),
                'current_page'  =>$productos->currentPage(),
                'per_page'      =>$productos->perPage(),
                'last_page'     =>$productos->lastPage(),
                'from'          =>$productos->firstItem(),
                'to'            =>$productos->lastItem(),
            ],
            'productos' =>  $productos
        ];

    }
    public function general()
    {
        //if(!$request->ajax()) return redirect('/');
        $materias = Tb_gestion_materia_prima::where('estado','=','1')
            ->select('tb_gestion_materia_prima.id as idMateria','tb_gestion_materia_prima.gestionMateria as materia')
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
        $materiales = Tb_orden_produccion_detalle::join('tb_gestion_materia_prima','tb_orden_produccion_detalle.idGestionMateria','=','tb_gestion_materia_prima.id')
            ->select('tb_gestion_materia_prima.gestionMateria as producto','tb_gestion_materia_prima.idUnidadBase','tb_gestion_materia_prima.id')
            ->where('tb_orden_produccion_detalle.idOrdenProduccion', '=', $identificador)
            ->orderBy('tb_gestion_materia_prima.id','asc')
            ->get();

        return ['materiales' =>  $materiales];

    }
    public function factura(Request $request) //PARA TRAER DATOS ACORDE
    {
        //if(!$request->ajax()) return redirect('/');
        $proveedor=$request->proveedor;
        $materiales = Tb_kardex_almacen::join('tb_proveedores','tb_kardex_almacen.observaciones','=','tb_proveedores.id')
            ->select('tb_kardex_almacen.detalle as factura','tb_proveedores.razonSocial as proveedor')
            ->distinct('tb_kardex_almacen.detalle')
            ->where([
                ['tb_kardex_almacen.idDocumentos', '=', '1'],
                ['tb_kardex_almacen.tipologia', '=', '1'],
                ['tb_kardex_almacen.observaciones', '=', $proveedor],
            ])
            ->orderBy('tb_kardex_almacen.detalle','asc')
            ->get();

        return ['materiales' =>  $materiales];

    }
    public function materialfactura(Request $request) //PARA TRAER DATOS ACORDE
    {
        //if(!$request->ajax()) return redirect('/');
        $factura=$request->factura;
        $proveedor=$request->proveedor;
        $materiales = Tb_kardex_almacen::join('tb_gestion_materia_prima','tb_kardex_almacen.idGestionMateria','=','tb_gestion_materia_prima.id')
            ->select('tb_kardex_almacen.idGestionMateria','tb_gestion_materia_prima.gestionMateria as producto','tb_gestion_materia_prima.idUnidadBase','tb_gestion_materia_prima.id')
            ->distinct('tb_kardex_almacen.idGestionMateria')
            ->where([
                ['tb_kardex_almacen.idDocumentos', '=', '1'],
                ['tb_kardex_almacen.tipologia', '=', '1'],
                ['tb_kardex_almacen.detalle', '=', $factura],
                ['tb_kardex_almacen.observaciones', '=', $proveedor],
            ])
            ->orderBy('tb_gestion_materia_prima.id','asc')
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

        $precioSaldos = DB::table('tb_kardex_almacen')
        ->select('id','cantidad as cantidadA','cantidadSaldos as cantidadS','precioSaldos as precioS')
        ->where('tb_kardex_almacen.idGestionMateria','=', $idProducto)
        ->orderByDesc('id')
        ->limit(1)
        ->get();

        $precioSaldoscant= DB::table('tb_kardex_almacen')
        ->where('tb_kardex_almacen.idGestionMateria','=', $idProducto)
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

        $tb_kardex_almacen=new Tb_kardex_almacen();
        $tb_kardex_almacen->detalle=$detalle;
        $tb_kardex_almacen->cantidad=$cantidad;
        $tb_kardex_almacen->precio=$precio;
        $tb_kardex_almacen->idGestionMateria=$idProducto;
        $tb_kardex_almacen->observaciones=$observaciones;
        $tb_kardex_almacen->idDocumentos=$idDocumentos;
        $tb_kardex_almacen->tipologia=$tipologia;
        $tb_kardex_almacen->fecha=$fecha;
        $tb_kardex_almacen->cantidadSaldos=$suma1;
        $tb_kardex_almacen->precioSaldos=$suma2;
        $tb_kardex_almacen->save();
    }
}
