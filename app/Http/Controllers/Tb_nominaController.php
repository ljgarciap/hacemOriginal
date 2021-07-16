<?php

namespace App\Http\Controllers;
use App\Tb_nomina;
use App\Tb_vinculaciones;
use App\Tb_novedades;
use App\Tb_factores_nomina;
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
            ->where('tb_nomina.id', '>', '1')
            ->orderBy('tb_nomina.id','desc')->paginate(5);
        }
        else {
            # code...
            $nomina = Tb_nomina::select('tb_nomina.id','tb_nomina.fechaInicio as fecha','tb_nomina.fechaFin','tb_nomina.tipo','tb_nomina.estado')
            ->where('tb_nomina.id', '>', '1')
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
    { //abre función cálculo
// recibo el id de nómina a calcular y saco los datos; de aca tomaré las fechas para revisar las novedades
        $nomina = Tb_nomina::where('id','=',$request->id)
        ->select('id','fechaInicio','fechaFin','tipo','estado')->get();

        foreach($nomina as $guianomina){ //apertura foreach nomina
            $nominaid = $guianomina->id;
            $nominafechaInicio = $guianomina->fechaInicio;
            $nominafechaFin = $guianomina->fechaFin;
            $nominatipo = $guianomina->tipo;
            $nominaestado = $guianomina->estado;

        // basado en el rango de fechas entre inicio y fin verifico cuales vinculaciones están activas para trabajar con los empleados
        $vinculaciones = Tb_vinculaciones::where('estado','=','1')
        ->whereNull('fechaFin')
        ->orWhere([
            ['tb_vinculaciones.fechaInicio', '>', $nominafechaInicio],
            ['tb_vinculaciones.fechaFin', '<', $nominafechaFin],
        ])
        ->orWhere([
            ['tb_vinculaciones.fechaInicio', '<', $nominafechaInicio],
            ['tb_vinculaciones.fechaFin', '<', $nominafechaFin],
        ])
        ->select('id','tipoVinculacion','salarioBasicoMensual','fechaInicio','tiempoContrato','fechaFin','idEmpleado','idNivelArl','idEps','idPensiones','estado')->get();

         //dentro de este foreach voy a sacar los datos de los empleados que hacen parte de la nómina para buscar sus novedades
        foreach($vinculaciones as $guiavinculaciones){ //abre foreach vinculaciones
            $vinculacionesid = $guiavinculaciones->id;
            $vinculacionestipoVinculacion = $guiavinculaciones->tipoVinculacion;
            $vinculacionessalarioBasicoMensual = $guiavinculaciones->salarioBasicoMensual;
            $vinculacionesfechaInicio = $guiavinculaciones->fechaInicio;
            $vinculacionestiempoContrato = $guiavinculaciones->tiempoContrato;
            $vinculacionesfechaFin = $guiavinculaciones->fechaFin;
            $vinculacionesidEmpleado = $guiavinculaciones->idEmpleado;
            $vinculacionesidNivelArl = $guiavinculaciones->idNivelArl;
            $vinculacionesidEps = $guiavinculaciones->idEps;
            $vinculacionesidPensiones = $guiavinculaciones->idPensiones;
            $vinculacionesestado = $guiavinculaciones->estado;

        $sueldobase=$vinculacionessalarioBasicoMensual; //valor del empleado

        //estos vienen de la tabla novedades

        //debo evaluar primero el almacenamiento de novedades... en este punto que apenas voy a sacar la lista de novedades estoy haciendo un cambio
        //en la estructura de la tabla para tomar en cuenta cantidades y unidades aun no se valida correctamente si voy a traer un solo espacio calculado
        //de la tabla y validar contra ella al momento de ingresar o capturo datos y valido desde este punto.

        $novedades = Tb_novedades::where('tb_novedades.idEmpleado','=',$vinculacionesidEmpleado)
        ->where('tb_novedades.idNomina','=','1')->get(); //De aca me voy a traer los de la nomina sin liquidar, ojo tengo que ir cambiando el valor de ella

        $diaslabor=0;
        $valordiaslabor=0;
        $extrasdiurnas=0; // ejemplo
        $valorextrasdiurnas=0;
        $extrasnocturnas=0;
        $valorextrasnocturnas=0;
        $horasdominicales=0;
        $valorhorasdominicales=0;
        $extrasdominicalesdiurnas=0;
        $valorextrasdominicalesdiurnas=0;
        $extrasdominicalesnocturnas=0;
        $valorextrasdominicalesnocturnas=0;
        $horasrecargos=0;
        $valorhorasrecargos=0;
        $primaextralegal=0;
        $valorprimaextralegal=0;
        $bonificaciones=0; // valor bonif
        $valorbonificaciones=0;
        $comisiones=0; // valor comisiones
        $valorcomisiones=0;
        $viaticos=0; // valor viaticos
        $valorviaticos=0;
        $nofactorsalarial=0;
        $valornofactorsalarial=0;
        //hasta aca vienen de la tabla novedades

        foreach($novedades as $guianovedades){ //apertura calculo por empleado de novedades
            $novedadesid = $guianovedades->id;
            $novedadesfechaNovedad = $guianovedades->fechaNovedad;
            $novedadesconcepto = $guianovedades->concepto;
            $novedadescantidad = $guianovedades->cantidad;
            $novedadesunitario = $guianovedades->unitario;
            $novedadesvalor = $guianovedades->valor;
            $novedadesobservacion = $guianovedades->observacion;
            $novedadestipologia = $guianovedades->tipologia;
            $novedadesidEmpleado = $guianovedades->idEmpleado;
            $novedadesidNomina = $guianovedades->idNomina;

            if($novedadesconcepto==1){
                $diaslabor=$diaslabor+$novedadescantidad;
                $valordiaslabor=$valordiaslabor+$novedadesvalor;
            }
            else if($novedadesconcepto==2 and $novedadesobservacion=='Extra Diurna'){
                $extrasdiurnas=$extrasdiurnas+$novedadescantidad;
                $valorextrasdiurnas=$valorextrasdiurnas+$novedadesvalor;
            }
            else if($novedadesconcepto==2 and $novedadesobservacion=='Extra Nocturna'){
                $extrasnocturnas=$extrasnocturnas+$novedadescantidad;
                $valorextrasnocturnas=$valorextrasnocturnas+$novedadesvalor;
            }
            else if($novedadesconcepto==2 and $novedadesobservacion=='Hora Dominical o Festiva'){
                $horasdominicales=$horasdominicales+$novedadescantidad;
                $valorhorasdominicales=$valorhorasdominicales+$novedadesvalor;
            }
            else if($novedadesconcepto==2 and $novedadesobservacion=='Extra Dominical o Festiva Diurna'){
                $extrasdominicalesdiurnas=$extrasdominicalesdiurnas+$novedadescantidad;
                $valorextrasdominicalesdiurnas=$valorextrasdominicalesdiurnas+$novedadesvalor;
            }
            else if($novedadesconcepto==2 and $novedadesobservacion=='Extra Dominical o Festiva Nocturna'){
                $extrasdominicalesnocturnas=$extrasdominicalesnocturnas+$novedadescantidad;
                $valorextrasdominicalesnocturnas=$valorextrasdominicalesnocturnas+$novedadesvalor;
            }
            else if($novedadesconcepto==2 and $novedadesobservacion=='Recargos'){
                $horasrecargos=$horasrecargos+$novedadescantidad;
                $valorhorasrecargos=$valorhorasrecargos+$novedadesvalor;
            }
            else if($novedadesconcepto==3){
                $primaextralegal=$primaextralegal+$novedadescantidad;
                $valorprimaextralegal=$valorprimaextralegal+$novedadesvalor;
            }
            else if($novedadesconcepto==4){
                $bonificaciones=$bonificaciones+$novedadescantidad;
                $valorbonificaciones=$valorbonificaciones+$novedadesvalor;
            }
            else if($novedadesconcepto==5){
                $comisiones=$comisiones+$novedadescantidad;
                $valorcomisiones=$valorcomisiones+$novedadesvalor;
            }
            else if($novedadesconcepto==6){
                $viaticos=$viaticos+$novedadescantidad;
                $valorviaticos=$valorviaticos+$novedadesvalor;
            }
            else if($novedadesconcepto==7){
                $nofactorsalarial=$nofactorsalarial+$novedadescantidad;
                $valornofactorsalarial=$valornofactorsalarial+$novedadesvalor;
            }

        //estos vienen de la tabla factores nomina
        $factores = Tb_factores_nomina::where('id','=','1')
        ->select('id','extraDiurna','extraNocturna','horaDominical','festivaDiurna','festivaNocturna','recargos','minimolegal','auxilio')->get();

        foreach($factores as $totalg){
            $multextrasdiurnas = $totalg->extraDiurna;
            $multextrasnocturnas = $totalg->extraNocturna;
            $multhorasdominicales = $totalg->horaDominical;
            $multextrasdominicalesdiurnas = $totalg->festivaDiurna;
            $multextrasdominicalesnocturnas = $totalg->festivaNocturna;
            $multrecargos = $totalg->recargos;
            $salariominimo = $totalg->minimolegal;
            $auxilioley = $totalg->auxilio;
        }
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

        //Variante importante, toma en cuenta los valores para los conceptos que no son extras
        $devengados=($sueldocalculado+$horasextras+$recargos+$valorbonificaciones+$valorcomisiones+$valorviaticos+$valornofactorsalarial); //suma de conceptos de horas extras y demás menos el auxilio de transporte

        if($sueldobase<=(2*$salariominimo)){
            $auxilio=intval(($auxilioley/$diasbase)*$diaslabor);
        }
        else{
            $auxilio=0;
        }

        $devengadoauxilio=($devengados+$auxilio);
        $ibcsalario=($devengados-$valornofactorsalarial);

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

            } // cierre calculo por empleado de novedades

        } //cierre foreach vinculaciones


        }  //cierre foreach nomina

    } //cierre función cálculo

//---------------------------------------------------------------------------------------------------//
// Cálculo de nómina
//---------------------------------------------------------------------------------------------------//

}
