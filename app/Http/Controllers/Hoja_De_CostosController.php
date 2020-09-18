<?php

namespace App\Http\Controllers;

use App\Tb_materia_prima_producto;
use App\Tb_mano_de_obra_producto;
use App\Tb_concepto_cif;
use App\Tb_maquinaria;
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

            //directa
            $query = DB::raw("(CASE WHEN SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) IS NULL THEN 0
            ELSE SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) END) as acumuladomd");
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
            ELSE SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) END) as acumuladomi");
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
            ELSE SUM(tb_mano_de_obra_producto.tiempo*tb_mano_de_obra_producto.precio) END) as acumuladomo");
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
                $total = $acumuladomaquinaria + $total;
            }

            $totales = ([
                [
                'acumuladomd'         => $acumuladomd,
                'acumuladomd'         => $acumuladomd,
                'acumuladomi'         => $acumuladomi,
                'acumuladomo'         => $acumuladomo,
                'acumuladocif'        => $acumuladocif,
                'acumuladomaquinaria' => $acumuladomaquinaria,
                'acumuladototal'      => $total
                ]
            ]);

            return ['totales' => $totales];

        }

}
