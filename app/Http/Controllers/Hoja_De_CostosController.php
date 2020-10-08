<?php

namespace App\Http\Controllers;

use App\Tb_materia_prima_producto;
use App\Tb_mano_de_obra_producto;
use App\tb_hoja_de_costo;
use App\Tb_concepto_cif;
use App\Tb_maquinaria;
use App\Tb_producto;
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
                $total = $acumuladocif + $total;
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
                $total = $acumuladomaquinaria + $total;
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
            $capacidadproducto = 0;
            $acumuladocapacidad = 0;
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

            $productos=tb_hoja_de_costo::findOrFail($identificador)->select('capacidadMensual')->get();
            foreach($productos as $producto){
                $capacidadmensual = $producto->capacidadMensual;
                $capacidadproducto = $capacidadproducto+$capacidadmensual;
            }

            //capacidadproduccion
            $capacidades = tb_hoja_de_costo::where('estado','=','1')
            ->select('capacidadMensual')->get();
            foreach($capacidades as $capacidad){
                $acumuladocapacidad = $capacidad->capacidadMensual + $acumuladocapacidad;
            }

            $maquinarias = ([
                [
                'id'                  => $id,
                'acumuladomaquinaria' => $acumuladomaquinaria,
                'capacidadproducto'   => $capacidadproducto,
                'acumuladocapacidad'  => $acumuladocapacidad
                ]
            ]);

            return ['maquinarias' => $maquinarias];

        }

}
