<?php

namespace App\Http\Controllers;

use App\Tb_puntos_equilibrio;
use App\tb_precios_venta;
use App\Tb_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Tb_simulacionesController extends Controller
{
    //
    public function storePrecioVenta(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $hoy = date("Y-m-d");

        $idProducto=$request->idProducto;
        $porcentaje=$request->porcentaje;
        $costo=$request->costo;
        $valorparcial=(100-$porcentaje)/100;
        if($valorparcial==0){
            $precioventa=$costo;
        }
        else{
            $precioventa=$costo/$valorparcial;
        }

        $producto='';

        $productos = Tb_producto::where('id','=',$idProducto)->select('producto')->get();
        foreach($productos as $product){
            $producto = $product->producto;
        }

        $detalle=$producto."-".$hoy;

        $tb_precios_venta=new Tb_precios_venta();
        $tb_precios_venta->idProducto=$idProducto;
        $tb_precios_venta->costo=$costo;
        $tb_precios_venta->porcentaje=$porcentaje;
        $tb_precios_venta->preciodeventa=$precioventa;
        $tb_precios_venta->detalle=$detalle;

        $tb_precios_venta->save();
    }

    public function storePuntoEquilibrio(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $hoy = date("Y-m-d");

        $idProducto=$request->idProducto;
        $preciodeventa=$request->preciodeventa;
        $costosfijos=$request->costosfijos;
        $gastosfijos=$request->gastosfijos;
        $costosygastos=$costosfijos+$gastosfijos;
        $materiaprima=$request->materiaprima;
        $manodeobradirecta=$request->manodeobradirecta;
        $costosvariables=$materiaprima+$manodeobradirecta;
        $valorparcial1=$preciodeventa-$costosvariables;
        if($valorparcial1==0){
            $puntoequilibrio=1;
        }
        else{
            $puntoequilibrio=$costosygastos/$valorparcial1;
        }

        $producto='';

        $productos = Tb_producto::where('id','=',$idProducto)->select('producto')->get();
        foreach($productos as $product){
            $producto = $product->producto;
        }

        $detalle=$producto."-".$hoy;

        $tb_puntos_equilibrio=new Tb_puntos_equilibrio();
        $tb_puntos_equilibrio->idProducto=$idProducto;
        $tb_puntos_equilibrio->preciodeventa=$preciodeventa;
        $tb_puntos_equilibrio->costosfijos=$costosfijos;
        $tb_puntos_equilibrio->gastosfijos=$gastosfijos;
        $tb_puntos_equilibrio->materiaprima=$materiaprima;
        $tb_puntos_equilibrio->manodeobradirecta=$manodeobradirecta;
        $tb_puntos_equilibrio->puntodeequilibrio=$puntoequilibrio;
        $tb_puntos_equilibrio->detalle=$detalle;

        $tb_puntos_equilibrio->save();
    }

}
