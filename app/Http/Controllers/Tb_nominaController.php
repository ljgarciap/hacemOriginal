<?php

namespace App\Http\Controllers;
use App\Tb_nomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Tb_nominaController extends Controller
{
    //
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            # Modelo::join('tablaqueseune',basicamente un on)
            $nomina = Tb_nomina::select('tb_nomina.id','tb_nomina.fechaInicio as fecha','tb_nomina.fechaFin','tb_nomina.tipo','tb_nomina.estado')
            ->orderBy('tb_nomina.id','desc')->paginate(5);
        }
        else {
            # code...
            $nomina = Tb_nomina::select('tb_nomina.id','tb_nomina.fechaInicio as fecha','tb_nomina.fechaFin','tb_nomina.tipo','tb_nomina.estado')
            ->where('tb_nomina.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_nomina.id','desc')->paginate(5);

        }

        return [
            'pagination' => [
                'total'         =>$nomina->total(),
                'current_page'  =>$nomina->currentPage(),
                'per_page'      =>$nomina->perPage(),
                'last_page'     =>$nomina->lastPage(),
                'from'          =>$nomina->firstItem(),
                'to'            =>$nomina->lastItem(),
            ],
                'nomina' => $nomina
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=new Tb_nomina();
        $tb_nomina->fechaInicio=$request->fechaInicio;
        //$tb_nomina->fechaFin=$request->fechaFin;
        $tb_nomina->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=Tb_nomina::findOrFail($request->id);
        //$tb_nomina->fechaInicio=$request->fechaInicio;
        $tb_nomina->fechaFIn=$request->fechaFin;
        $tb_nomina->estado=1;
        $tb_nomina->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=Tb_nomina::findOrFail($request->id);
        $tb_nomina->estado=0;
        $tb_nomina->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_nomina=Tb_nomina::findOrFail($request->id);
        $tb_nomina->estado=1;
        $tb_nomina->save();
    }

//---------------------------------------------------------------------------------------------------//
// Cálculo de nómina
//---------------------------------------------------------------------------------------------------//

    public function calcularNomina(Request $request)
    {

        $sueldobase=750000; //valor del empleado

//estos vienen de la tabla novedades
        $diaslabor=30;
        $extrasdiurnas=0; // ejemplo
        $extrasnocturnas=0;
        $horasdominicales=0;
        $extrasdominicalesdiurnas=0;
        $extrasdominicalesnocturnas=0;
        $horasrecargos=0;
        $bonificaciones=0; // valor bonif
        $comisiones=0; // valor comisiones
        $viaticos=0; // valor viaticos
        $nofactorsalarial=0;
//hasta aca vienen de la tabla novedades

//estos vienen de la tabla factores nomina
        $salariominimo=908526; //valor real
        $auxilioley=106454; //valor real
        $multextrasdiurnas=1.25;
        $multextrasnocturnas=1.75;
        $multhorasdominicales=1.75;
        $multextrasdominicalesdiurnas=2;
        $multextrasdominicalesnocturnas=2.5;
        $multrecargos=0.35;
//hasta aca vienen de la tabla factores nomina

        $topesalarios=(25*$salariominimo);
        $diasbase=30; // total dias mes
        $horasbase=(8*$diasbase);
        $sueldobasehora=($sueldobase/$horasbase);
        $sueldocalculado=(($sueldobase/$diasbase)*$diaslabor);

        $totalextrasdiurnas=intval($extrasdiurnas*$multextrasdiurnas*$sueldobasehora); // ejemplo
        $totalextrasnocturnas=intval($extrasnocturnas*$multextrasnocturnas*$sueldobasehora);
        $totalhorasdominicales=intval($horasdominicales*$multhorasdominicales*$sueldobasehora);
        $totalextrasdominicalesdiurnas=intval($extrasdominicalesdiurnas*$multextrasdominicalesdiurnas*$sueldobasehora);
        $totalextrasdominicalesnocturnas=intval($extrasdominicalesnocturnas*$multextrasdominicalesnocturnas*$sueldobasehora);

        $horasextras=$totalextrasdiurnas+$totalextrasnocturnas+$totalhorasdominicales+$totalextrasdominicalesdiurnas+$totalextrasdominicalesnocturnas; //suma de todas las tipologias de horas extras

        $recargos=intval($horasrecargos*$multrecargos); //valor de los recargos

        $devengados=($sueldocalculado+$horasextras+$recargos+$bonificaciones+$comisiones+$viaticos+$nofactorsalarial); //suma de conceptos de horas extras y demás menos el auxilio de transporte

        if($sueldobase<=(2*$salariominimo)){
            $auxilio=intval(($auxilioley/$diasbase)*$diaslabor);
        }
        else{
            $auxilio=0;
        }

        $devengadoauxilio=($devengados+$auxilio);
        $ibcsalario=($devengados-$nofactorsalarial);

        /*
            Validación ibc e ibc con tope
        */

        if($ibcsalario>0){ //si el ibcsalario tiene valor
            if($ibcsalario>$topesalarios){ // si el ibcsalario tiene valor y es mayor que los 25 salarios
                $ibccontope=$topesalarios;
            }
            else{ // else si el ibcsalario tiene valor y es menor que los 25 salarios

                if($diaslabor<$diasbase){ // si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son menos que los del mes

                    if(($ibcsalario/$diaslabor)>($salariominimo/$diasbase)){ // si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son menos que los del mes y el ibcsalario es mas que el minimo
                        $ibccontope=$ibcsalario;
                    }
                    else{ // else si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son menos que los del mes y el ibcsalario es menos que el minimo
                        $ibccontope=(($salariominimo/$diasbase)*$diaslabor);
                    }
                }
                else{ // else si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son los del mes
                    if($ibcsalario<$salariominimo){
                        $ibccontope=$salariominimo;
                    }
                    else{
                        $ibccontope=$ibcsalario;
                    }
                }
            }
        }
        else{ //else si el ibcsalario no tiene valor
            $ibccontope=0;
        }

        /*
            Fin Validación ibc e ibc con tope
        */

    }

//---------------------------------------------------------------------------------------------------//
// Cálculo de nómina
//---------------------------------------------------------------------------------------------------//

}
