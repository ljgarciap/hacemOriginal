<?php

namespace App\Http\Controllers;

use App\Tb_materia_prima_producto;
use App\Tb_mano_de_obra_producto;
use App\tb_hoja_de_costo;
use App\Tb_concepto_cif;
use App\Tb_maquinaria;
use App\Tb_producto;
use App\Tb_rela_simulacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\ArrayInput;

class Hoja_De_CostosController extends Controller
{
        public function acumuladoTotal($identificador)
        {
            $total = 0;
            $acumuladomd = 0;
            $acumuladomi = 0;
            $acumuladomo = 0;
            $acumuladocif = 0;
            $acumuladomaquinaria = 0;
            $acumuladocift = 0;
            $acumuladotiempomo = 0;
            $capacidadproducto = 0;
            $acumuladocapacidad = 0;

            //directa
            $query = DB::raw("(CASE WHEN SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) IS NULL THEN 0
            ELSE ROUND(SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio),0) END) as acumuladomd");
            $materiadirecta = DB::table('tb_materia_prima_producto')
            ->select($query)
            ->where([
                ['tb_materia_prima_producto.idHoja','=',$identificador],
                ['tb_materia_prima_producto.tipoDeCosto', '=', 'Directo'],
            ])->get();
            foreach($materiadirecta as $materiad){
            $acumuladomd = $materiad->acumuladomd + $acumuladomd;
            $total = $acumuladomd + $total;
            }

            //indirecta
            $query1 = DB::raw("(CASE WHEN SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) IS NULL THEN 0
            ELSE ROUND(SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio),0) END) as acumuladomi");
            $materiaindirecta = DB::table('tb_materia_prima_producto')
            ->select($query1)
            ->where([
                ['tb_materia_prima_producto.idHoja','=',$identificador],
                ['tb_materia_prima_producto.tipoDeCosto', '=', 'Indirecto'],
            ])->get();
            foreach($materiaindirecta as $materiaind){
                $acumuladomi = $materiaind->acumuladomi + $acumuladomi;
                $total = $acumuladomi + $total;
            }

            //manodeobra
            $query2 = DB::raw("(CASE WHEN SUM(tb_mano_de_obra_producto.tiempo*tb_mano_de_obra_producto.precio) IS NULL THEN 0
            ELSE ROUND(SUM(tb_mano_de_obra_producto.tiempo*tb_mano_de_obra_producto.precio),0) END) as acumuladomo");
            $manodeobra = DB::table('tb_mano_de_obra_producto')
            ->select($query2)
            ->where('tb_mano_de_obra_producto.idHoja','=',$identificador)
            ->get();
            foreach($manodeobra as $manodeo){
                $acumuladomo = $manodeo->acumuladomo + $acumuladomo;
                $total = $acumuladomo + $total;
            }

            //cif
            $query3 = DB::raw("(CASE WHEN SUM(tb_concepto_cif.valor) IS NULL THEN 0
            ELSE SUM(tb_concepto_cif.valor) END) as acumuladocif");
            $ciftotales = DB::table('tb_concepto_cif')
            ->select($query3)
            ->get();
            foreach($ciftotales as $ciftotal){
                $acumuladocif = $ciftotal->acumuladocif + $acumuladocif;
                $acumuladocift = $acumuladocift + $acumuladocif;
            }

            //maquinaria
            $query4 = DB::raw("(CASE WHEN SUM(tb_maquinaria.depreciacionMensual) IS NULL THEN 0
            ELSE SUM(tb_maquinaria.depreciacionMensual) END) as acumuladomaquinaria");
            $totales = DB::table('tb_maquinaria')
            ->select($query4)
            ->get();
            foreach($totales as $totalg){
                $acumuladomaquinaria = $totalg->acumuladomaquinaria + $acumuladomaquinaria;
                $acumuladocift = $acumuladocift + $acumuladomaquinaria;
            }

            //tiempomanodeobra
            $query5 = DB::raw("(CASE WHEN SUM(tb_mano_de_obra_producto.tiempo) IS NULL THEN 0
            ELSE ROUND(SUM(tb_mano_de_obra_producto.tiempo),0) END) as acumuladotiempomo");
            $tiempomanodeobra = DB::table('tb_mano_de_obra_producto')
            ->select($query5)
            ->where('tb_mano_de_obra_producto.idHoja','=',$identificador)
            ->get();
            foreach($tiempomanodeobra as $tmanodeo){
                $acumuladotiempomo = $tmanodeo->acumuladotiempomo + $acumuladotiempomo;
            }

            $productos=Tb_producto::findOrFail($identificador)->select('foto','producto')->get();
            foreach($productos as $producto){
                $foto = $producto->foto;
                $producto = $producto->producto;
            }

            //capacidadproduccion
            $productos=tb_hoja_de_costo::where('id','=',$identificador)->select('capacidadMensual')->first();
            $capacidadmensual = $productos->capacidadMensual;
            $capacidadproducto = $capacidadproducto+$capacidadmensual;

            $capacidades = tb_hoja_de_costo::where('estado','=','1')
            ->select('capacidadMensual')->get();
            foreach($capacidades as $capacidad){
                $acumuladocapacidad = $capacidad->capacidadMensual + $acumuladocapacidad;
            }

            $cifporproducto=intval($acumuladocift/$capacidadproducto);
            $ciftotalaterrizada=intval($acumuladocift/$acumuladocapacidad);
            $total=$total+$cifporproducto;

            $totales = ([
                [
                'acumuladomd'         => $acumuladomd,
                'acumuladomd'         => $acumuladomd,
                'acumuladomi'         => $acumuladomi,
                'acumuladomo'         => $acumuladomo,
                'acumuladocif'        => $acumuladocif,
                'acumuladomaquinaria' => $acumuladomaquinaria,
                'acumuladocift'       => $acumuladocift,
                'acumuladototal'      => $total,
                'capacidadproducto'   => $capacidadproducto,
                'cifporproducto'      => $cifporproducto,
                'ciftotalaterrizada'  => $ciftotalaterrizada,
                'acumuladotiempomo'   => $acumuladotiempomo,
                'foto'                => $foto,
                'producto'            => $producto
                ]
            ]);

            return ['totales' => $totales];

        }

        public function maquinariaTotal($identificador)
        {
            $acumuladomaquinaria = 0;
            $id = 1;

            //maquinaria
            $query = DB::raw("(CASE WHEN SUM(tb_maquinaria.depreciacionMensual) IS NULL THEN 0
            ELSE SUM(tb_maquinaria.depreciacionMensual) END) as acumuladomaquinaria");
            $totales = DB::table('tb_maquinaria')
            ->select($query)
            ->get();
            foreach($totales as $totalg){
                $acumuladomaquinaria = $totalg->acumuladomaquinaria + $acumuladomaquinaria;
            }

            $maquinarias = $acumuladomaquinaria;
            return ['maquinarias' => $maquinarias];
        }

        public function cifTiempos($identificador)
        {
            //cif
            $acumuladocif = 0;
            $acumuladomaquinaria = 0;
            $acumuladocift = 0;

            $query3 = DB::raw("(CASE WHEN SUM(tb_concepto_cif.valor) IS NULL THEN 0
            ELSE SUM(tb_concepto_cif.valor) END) as acumuladocif");
            $ciftotales = DB::table('tb_concepto_cif')
            ->select($query3)
            ->get();
            foreach($ciftotales as $ciftotal){
                $acumuladocif = $ciftotal->acumuladocif + $acumuladocif;
                $acumuladocift = $acumuladocift + $acumuladocif;
            }

            //maquinaria
            $query4 = DB::raw("(CASE WHEN SUM(tb_maquinaria.depreciacionMensual) IS NULL THEN 0
            ELSE SUM(tb_maquinaria.depreciacionMensual) END) as acumuladomaquinaria");
            $totales = DB::table('tb_maquinaria')
            ->select($query4)
            ->get();
            foreach($totales as $totalg){
                $acumuladomaquinaria = $totalg->acumuladomaquinaria + $acumuladomaquinaria;
                $acumuladocift = $acumuladocift + $acumuladomaquinaria;
            }

            $acumuladoproduccion=0;
            $acumuladotiempo=0;
            $acumuladocalculo=0;

            $query = DB::raw("SUM(tb_rela_simulacion.unidades) as acumuladoprod,SUM(tb_rela_simulacion.tiempo) as acumuladotiem,
            SUM(tb_rela_simulacion.unidades * tb_rela_simulacion.tiempo) as acumuladocalc");
            $totalprod = DB::table('tb_rela_simulacion')->where('idSimulacion','=',$identificador)
            ->select($query)
            ->get();

            foreach($totalprod as $totalpr){
                $acumuladoproduccion = $totalpr->acumuladoprod + $acumuladoproduccion;
                $acumuladotiempo = $totalpr->acumuladotiem + $acumuladotiempo;
                $acumuladocalculo = $totalpr->acumuladocalc + $acumuladocalculo;
            }

            $produccion = $acumuladoproduccion;
            $tiempo = round($acumuladotiempo, 2);

            $valorbase=round(($acumuladocift/$acumuladocalculo),2);
            /*
            $totalcif=round(($valorbase*1800));//valorbase * horastotales -- 3665576
            $unitariocif=round(($totalcif/1200));//totalcif / unidades -- 3055
            */
            $productos = Tb_rela_simulacion::join('tb_producto','tb_rela_simulacion.idProducto','=','tb_producto.id')
            ->select('tb_rela_simulacion.id','tb_rela_simulacion.unidades','tb_rela_simulacion.tiempo','tb_producto.producto',
            'tb_producto.referencia','tb_producto.descripcion')
            ->where('tb_rela_simulacion.idSimulacion', '=', $identificador)->get();
            return [
                'productos' => $productos,
                'produccion' => $produccion,
                //'tiempo' => $tiempo,
                'acumuladocift' => $acumuladocift,
                'acumuladocalculo' => $acumuladocalculo,
                'valorbase' => $valorbase
            ];

        }

}
