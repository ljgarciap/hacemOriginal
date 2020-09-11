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
        $materiadirecta = DB::table('tb_materia_prima_producto')
        ->select(DB::raw('sum(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) as acumuladomd'))
        ->where([
            ['tb_materia_prima_producto.idHoja','=',$identificador],
            ['tb_materia_prima_producto.tipoDeCosto', '=', 'Directo'],
        ])->get();

        return ['materiadirecta' => $materiadirecta];

        }

    public function materiaIndirecta($identificador)
    {
        $materiaindirecta = DB::table('tb_materia_prima_producto')
        ->select(DB::raw('sum(tb_materia_prima_producto.cantidad*tb_materia_prima_producto.precio) as acumuladomi'))
        ->where([
            ['tb_materia_prima_producto.idHoja','=',$identificador],
            ['tb_materia_prima_producto.tipoDeCosto', '=', 'Indirecto'],
        ])->get();

        return ['materiaindirecta' => $materiaindirecta];

        }

    public function manoDeObra($identificador)
    {
            $manodeobra = DB::table('tb_mano_de_obra_producto')
            ->select(DB::raw('sum(tb_mano_de_obra_producto.tiempo*tb_mano_de_obra_producto.precio) as acumuladomo'))
            ->where('tb_mano_de_obra_producto.idHoja','=',$identificador)
            ->get();

            return ['manodeobra' => $manodeobra];

        }

}
