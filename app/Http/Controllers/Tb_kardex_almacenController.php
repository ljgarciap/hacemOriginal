<?php

namespace App\Http\Controllers;
use App\Tb_kardex_almacen;
use App\Tb_gestion_materia_prima;
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
            ->paginate(5);
        }
        else {
            $productos = Tb_kardex_almacen::join('tb_gestion_materia_prima','tb_kardex_almacen.idGestionMateria','=','tb_gestion_materia_prima.id')
            ->select(Tb_kardex_almacen::raw('tb_kardex_almacen.cantidadSaldos * tb_kardex_almacen.precioSaldos as saldos,
            tb_kardex_almacen.id,tb_kardex_almacen.fecha,tb_kardex_almacen.detalle,tb_kardex_almacen.cantidad,
            tb_kardex_almacen.precio,tb_kardex_almacen.cantidadSaldos,tb_kardex_almacen.precioSaldos,tb_kardex_almacen.idGestionMateria,
            tb_kardex_almacen.tipologia,tb_gestion_materia_prima.id,tb_gestion_materia_prima.gestionMateria as producto,
            tb_gestion_materia_prima.idUnidadBase,tb_gestion_materia_prima.estado'))
            ->where('tb_kardex_almacen.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_kardex_almacen.id','desc')->paginate(5);
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

    public function prueba(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
 /**/
            $productos = Tb_kardex_almacen::join('tb_gestion_materia_prima','tb_kardex_almacen.idGestionMateria','=','tb_gestion_materia_prima.id')
            ->select('tb_kardex_almacen.id','tb_kardex_almacen.fecha','tb_kardex_almacen.detalle','tb_kardex_almacen.cantidad',
            'tb_kardex_almacen.precio','tb_kardex_almacen.cantidadSaldos','tb_kardex_almacen.precioSaldos','tb_kardex_almacen.idGestionMateria',
            'tb_kardex_almacen.tipologia','tb_gestion_materia_prima.gestionMateria as producto','tb_gestion_materia_prima.idUnidadBase',
            'tb_gestion_materia_prima.estado',DB::raw('tb_kardex_almacen.cantidadSaldos * tb_kardex_almacen.precioSaldos as saldos'))
            ->whereIn('tb_kardex_almacen.id', function($sub){$sub->selectRaw('max(id)')->from('tb_kardex_almacen')->groupBy('idGestionMateria');})
            ->paginate(5);

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

    public function store(Request $request)
    {
        //capturo cantidad precio y producto; internamente busco el registro mas reciente de dicho producto y tomo el valor cantidad de ese registro,
        //ahora, miro los datos del ingreso nuevo, si es un 1 es un ingreso y sumo la nueva cantidad a la de cantidadSaldos del registro anterior,
        //si es 2 es una salida y lo que hago es restar la nueva cantidad de la de cantidadSaldos del registro anterior; el resultado va en el
        //registro nuevo en el campo cantidadSaldos; ahora para llenar el campo de precioSaldos (que es el precio promedio) lo que hago es del registro
        //anterior multiplico cantidadSaldos*precioSaldos y a ese valor le sumo o resto segun el caso el valor del registro nuevo que resulta de
        //cantidad*precio; el resultado lo divido entre el valor que calcule de cantidadSaldos y lo ingreso en precioSaldos; hay que tener muy en
        //cuenta que en el primer registro las cantidad y cantidadSaldos asi como las precio y precioSaldos son identicas.
    }

}
