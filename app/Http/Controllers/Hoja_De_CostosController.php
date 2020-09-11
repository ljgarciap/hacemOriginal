<?php

namespace App\Http\Controllers;

use App\Tb_materia_prima_producto;
use App\Tb_mano_de_obra_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Hoja_De_CostosController extends Controller
{
    //
    public function materiaDirecta($identificador)
    {
        $query = DB::raw("(CASE WHEN SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) IS NULL THEN 0
        ELSE SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) END) as acumuladomd");

        $materiadirecta = DB::table('tb_materia_prima_producto')
        ->select($query)
        ->where([
            ['tb_materia_prima_producto.idHoja','=',$identificador],
            ['tb_materia_prima_producto.tipoDeCosto', '=', 'Directo'],
        ])->get();

        return ['materiadirecta' => $materiadirecta];

        }

    public function materiaIndirecta($identificador)
    {
        $query = DB::raw("(CASE WHEN SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) IS NULL THEN 0
        ELSE SUM(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) END) as acumuladomi");

        $materiaindirecta = DB::table('tb_materia_prima_producto')
        ->select($query)
        ->where([
            ['tb_materia_prima_producto.idHoja','=',$identificador],
            ['tb_materia_prima_producto.tipoDeCosto', '=', 'Indirecto'],
        ])->get();

        return ['materiaindirecta' => $materiaindirecta];

        }

    public function manoDeObra($identificador)
    {
        $query = DB::raw("(CASE WHEN SUM(tb_mano_de_obra_producto.tiempo*tb_mano_de_obra_producto.precio) IS NULL THEN 0
        ELSE SUM(tb_mano_de_obra_producto.tiempo*tb_mano_de_obra_producto.precio) END) as acumuladomo");

        $manodeobra = DB::table('tb_mano_de_obra_producto')
        ->select($query)
        ->where('tb_mano_de_obra_producto.idHoja','=',$identificador)
        ->get();

        return ['manodeobra' => $manodeobra];

        }

}
