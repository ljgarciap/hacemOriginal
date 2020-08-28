<?php

namespace App\Http\Controllers;

use App\Tb_materia_prima_producto;
use App\Tb_gestion_materia_prima;
use App\Tb_unidad_base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_materia_prima_productoController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $materiaprimaproductos = Tb_materia_prima_producto::join("tb_gestion_materia_prima","tb_materia_prima_producto.idMateriaPrima","=","tb_gestion_materia_prima.id")
            ->leftJoin('tb_unidad_base',function($join){
                $join->on('tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id');
            })
            ->select('tb_materia_prima_producto.id', 'tb_gestion_materia_prima.id AS idGestionMateria',
            'tb_gestion_materia_prima.gestionMateria', 'tb_gestion_materia_prima.precioBase',
            'tb_unidad_base.id AS idUnidadBase', 'tb_unidad_base.unidadBase', 'tb_materia_prima_producto.cantidad',
            'tb_materia_prima_producto.precio', 'tb_materia_prima_producto.tipoDeCosto', 'tb_materia_prima_producto.idHoja',
            DB::raw('(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) as subtotal'))
            ->orderBy('tb_gestion_materia_prima.id','desc')->paginate(5);
        }
        else if($criterio=='materiaprima'){
            $materiaprimaproductos = Tb_materia_prima_producto::join("tb_gestion_materia_prima","tb_materia_prima_producto.idMateriaPrima","=","tb_gestion_materia_prima.id")
            ->leftJoin('tb_unidad_base',function($join){
                $join->on('tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id');
            })
            ->select('tb_materia_prima_producto.id', 'tb_gestion_materia_prima.id AS idGestionMateria',
            'tb_gestion_materia_prima.gestionMateria', 'tb_gestion_materia_prima.precioBase',
            'tb_unidad_base.id AS idUnidadBase', 'tb_unidad_base.unidadBase', 'tb_materia_prima_producto.cantidad',
            'tb_materia_prima_producto.precio', 'tb_materia_prima_producto.tipoDeCosto', 'tb_materia_prima_producto.idHoja',
            DB::raw('(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) as subtotal'))
            ->where('tb_gestion_materia_prima.gestionMateria', 'like', '%'. $buscar . '%')
            ->orderBy('tb_gestion_materia_prima.id','desc')->paginate(5);
        }
        else {
            $materiaprimaproductos = Tb_materia_prima_producto::join("tb_gestion_materia_prima","tb_materia_prima_producto.idMateriaPrima","=","tb_gestion_materia_prima.id")
            ->leftJoin('tb_unidad_base',function($join){
                $join->on('tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id');
            })
            ->select('tb_materia_prima_producto.id', 'tb_gestion_materia_prima.id AS idGestionMateria',
            'tb_gestion_materia_prima.gestionMateria', 'tb_gestion_materia_prima.precioBase',
            'tb_unidad_base.id AS idUnidadBase', 'tb_unidad_base.unidadBase', 'tb_materia_prima_producto.cantidad',
            'tb_materia_prima_producto.precio', 'tb_materia_prima_producto.tipoDeCosto', 'tb_materia_prima_producto.idHoja',
            DB::raw('(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) as subtotal'))
            ->where('tb_gestion_materia_prima.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_gestion_materia_prima.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$materiaprimaproductos->total(),
                'current_page'  =>$materiaprimaproductos->currentPage(),
                'per_page'      =>$materiaprimaproductos->perPage(),
                'last_page'     =>$materiaprimaproductos->lastPage(),
                'from'          =>$materiaprimaproductos->firstItem(),
                'to'            =>$materiaprimaproductos->lastItem(),
            ],
                'materiaprimaproductos' => $materiaprimaproductos
        ];

    }

    public function selectMateriaPrimaProducto(){
        $materiaprimaproductos = Tb_materia_prima_producto::join("tb_gestion_materia_prima","tb_materia_prima_producto.idMateriaPrima","=","tb_gestion_materia_prima.id")
        ->leftJoin('tb_unidad_base',function($join){
            $join->on('tb_gestion_materia_prima.idUnidadBase','=','tb_unidad_base.id');
        })
        ->select('tb_materia_prima_producto.id', 'tb_gestion_materia_prima.id AS idGestionMateria',
        'tb_gestion_materia_prima.gestionMateria', 'tb_gestion_materia_prima.precioBase',
        'tb_unidad_base.id AS idUnidadBase', 'tb_unidad_base.unidadBase', 'tb_materia_prima_producto.cantidad',
        'tb_materia_prima_producto.precio', 'tb_materia_prima_producto.tipoDeCosto', 'tb_materia_prima_producto.idHoja',
        DB::raw('(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) as subtotal'))
        ->orderBy('tb_gestion_materia_prima.id','desc')->get();

        return ['materiaprimaproductos' => $materiaprimaproductos];
        }
}
