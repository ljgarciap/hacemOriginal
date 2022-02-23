<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Tb_nomina;
use App\Tb_vinculaciones;
use App\Tb_novedades;
use App\Tb_resumen_nomina;
use App\Tb_niveles_riesgo;
use App\Tb_riesgo_adicional;
use App\Tb_factores_nomina;
use Storage;

class CalcularNomina implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $nominaid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($nominaid)
    {
        //
        $this->nominaid = $nominaid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
//abre función cálculo
// recibo el id de nómina a calcular y saco los datos; de aca tomaré las fechas para revisar las novedades
$nomina_id = $this->nominaid;

$nomina = Tb_nomina::where('id','=',$nomina_id)
->select('id','fechaInicio','fechaFin','tipo','estado')->get();

foreach($nomina as $guianomina){ //apertura foreach nomina
    $nominaid = $guianomina->id;
    $nominafechaInicio = $guianomina->fechaInicio;
    $nominafechaFin = $guianomina->fechaFin;
    $nominatipo = $guianomina->tipo;
    $nominaestado = $guianomina->estado;
    }

//Distinct de novedades para sacar los empleados involucrados

$empleadonovedades = Tb_novedades::where('idNomina','=',$nominaid)->groupby('idEmpleado')->distinct()->select('idEmpleado')->get();

 //dentro de este foreach voy a sacar los datos de los empleados que hacen parte de la nómina para buscar sus novedades
foreach($empleadonovedades as $empleadonovedad){ //abre foreach vinculaciones

    $empleadonovedadid = $empleadonovedad->idEmpleado;

    // basado en el rango de fechas entre inicio y fin verifico cuales vinculaciones están activas para trabajar con los empleados
    $vinculaciones = Tb_vinculaciones::where('idEmpleado','=',$empleadonovedadid)
    ->whereNull('fechaFin')
    ->orWhere([
        ['tb_vinculaciones.fechaInicio', '>', $nominafechaInicio],
        ['tb_vinculaciones.fechaFin', '<', $nominafechaFin],
    ])
    ->orWhere([
        ['tb_vinculaciones.fechaInicio', '<', $nominafechaInicio],
        ['tb_vinculaciones.fechaFin', '<', $nominafechaFin],
    ])
    ->select('id','tipoContrato','tipoSalario','salarioBasicoMensual','fechaInicio','tiempoContrato','fechaFin','idEmpleado','idNivelArl','estado')->get();

     //dentro de este foreach voy a sacar los datos de los empleados que hacen parte de la nómina para buscar sus novedades
    foreach($vinculaciones as $guiavinculaciones){ //abre foreach vinculaciones

        $vinculacionesid = $guiavinculaciones->id;
        $vinculacionestipoVinculacion = $guiavinculaciones->tipoContrato;
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
    }

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
    $nofactorsalarial=0; // valor no factor
    $valornofactorsalarial=0;
    // seccion descuentos
    $porcentajeAdicional=0;
    $retencion=0; // valor retencion
    $valorretencion=0;
    $sindicato=0; // valor sindicato
    $valorsindicato=0;
    $prestamos=0; // valor prestamos
    $valorprestamos=0;
    $embargos=0; // valor embargos
    $valorembargos=0;
    $otros=0; // valor otros
    $valorotros=0;
    $descuentosalud=0;
    $descuentopension=0;
    $fondoSolidaridad=0;
    //hasta aca vienen de la tabla novedades

    //estos vienen de la tabla novedades

$novedades = Tb_novedades::where('tb_novedades.idEmpleado','=',$empleadonovedadid)
->where('tb_novedades.idNomina','=',$nominaid)->get(); //De aca me voy a traer los de la nomina sin liquidar, ojo tengo que ir cambiando el valor de ella

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
    else if($novedadesconcepto==50){
        $retencion=$retencion+$novedadescantidad;
        $valorretencion=$valorretencion+$novedadesvalor;
    }
    else if($novedadesconcepto==51){
        $sindicato=$sindicato+$novedadescantidad;
        $valorsindicato=$valorsindicato+$novedadesvalor;
    }
    else if($novedadesconcepto==52){
        $prestamos=$prestamos+$novedadescantidad;
        $valorprestamos=$valorprestamos+$novedadesvalor;
    }
    else if($novedadesconcepto==53){
        $embargos=$embargos+$novedadescantidad;
        $valorembargos=$valorembargos+$novedadesvalor;
    }
    else if($novedadesconcepto==54){
        $otros=$otros+$novedadescantidad;
        $valorotros=$valorotros+$novedadesvalor;
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

//ojo aca, estos valores están estáticos, pero deberían estar almacenados no se donde
$multdescuentosalud=0.04;
$multdescuentopension=0.04;
//ojo aca, estos valores están estáticos, pero deberían estar almacenados no se donde

$topesalarios=(25*$salariominimo);
$diasbase=30; // total dias mes
$horasbase=(8*$diasbase);
$sueldobasehora=($sueldobase/$horasbase);
$sueldocalculado=(($sueldobase/$diasbase)*$diaslabor);

$totalextrasdiurnas=intval($extrasdiurnas*$multextrasdiurnas*$sueldobasehora); // ejemplo calculado
$totalextrasnocturnas=intval($extrasnocturnas*$multextrasnocturnas*$sueldobasehora); // ejemplo calculado
$totalhorasdominicales=intval($horasdominicales*$multhorasdominicales*$sueldobasehora); // ejemplo calculado
$totalextrasdominicalesdiurnas=intval($extrasdominicalesdiurnas*$multextrasdominicalesdiurnas*$sueldobasehora); // ejemplo calculado
$totalextrasdominicalesnocturnas=intval($extrasdominicalesnocturnas*$multextrasdominicalesnocturnas*$sueldobasehora); // ejemplo calculado

$horasextras=$totalextrasdiurnas+$totalextrasnocturnas+$totalhorasdominicales+$totalextrasdominicalesdiurnas+$totalextrasdominicalesnocturnas;
//suma de todas las tipologias de horas extras ejemplo calculado

//-------------------------------------------------------------------------------------------------------------------------//
$total1extrasdiurnas=intval($valorextrasdiurnas); // ejemplo novedad
$total1extrasnocturnas=intval($valorextrasnocturnas); // ejemplo novedad
$total1horasdominicales=intval($valorhorasdominicales); // ejemplo novedad
$total1extrasdominicalesdiurnas=intval($valorextrasdominicalesdiurnas); // ejemplo novedad
$total1extrasdominicalesnocturnas=intval($valorextrasdominicalesnocturnas); // ejemplo novedad

$horas1extras=$total1extrasdiurnas+$total1extrasnocturnas+$total1horasdominicales+$total1extrasdominicalesdiurnas+$total1extrasdominicalesnocturnas;
//suma de todas las tipologias de horas extras ejemplo novedad
//-------------------------------------------------------------------------------------------------------------------------//

$recargos=intval($horasrecargos*$multrecargos*$sueldobasehora); //valor de los recargos ejemplo calculado

//Variante importante, toma en cuenta los valores para los conceptos que no son extras
$devengados=($sueldocalculado+$horasextras+$recargos+$valorbonificaciones+$valorcomisiones+$valorviaticos+$valornofactorsalarial);
//suma de conceptos de horas extras y demás menos el auxilio de transporte ejemplo calculado

//-------------------------------------------------------------------------------------------------------------------------//
//Variante importante, toma en cuenta los valores para los conceptos que no son extras
$devengados1=($valordiaslabor+$horas1extras+$recargos+$valorbonificaciones+$valorcomisiones+$valorviaticos+$valornofactorsalarial);
//suma de conceptos de horas extras y demás menos el auxilio de transporte ejemplo novedad
//-------------------------------------------------------------------------------------------------------------------------//

if($sueldobase<=(2*$salariominimo)){
    $auxilio=intval(($auxilioley/$diasbase)*$diaslabor);
}
else{
    $auxilio=0;
}

$devengadoauxilio=($devengados+$auxilio); // calculado
$ibcsalario=($devengados-$valornofactorsalarial); // calculado

$devengado1auxilio=($devengados1+$auxilio); //de novedad
$ibcsalario1=($devengados1-$valornofactorsalarial); //de novedad

/*
    Validación ibc e ibc con tope calculado
*/

if($ibcsalario>0){ //si el ibcsalario tiene valor
    if($ibcsalario>$topesalarios){ // si el ibcsalario tiene valor y es mayor que los 25 salarios
        $ibccontope=$topesalarios;
    }
    else{ // else si el ibcsalario tiene valor y es menor que los 25 salarios

        if($diaslabor<$diasbase){ // si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son menos que los del mes

            if($diaslabor==0){
                $ibcsadi=0;
            }
            else{
                $ibcsadi=($ibcsalario/$diaslabor);
            }

            if(($ibcsadi)>($salariominimo/$diasbase)){ // si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son menos que los del mes y el ibcsalario es mas que el minimo
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
    Fin Validación ibc e ibc con tope calculado
*/

//-----------------------------------------------------------------------------------------------//
/*
    Validación ibc e ibc con tope novedades
*/

if($ibcsalario1>0){ //si el ibcsalario tiene valor
    if($ibcsalario1>$topesalarios){ // si el ibcsalario tiene valor y es mayor que los 25 salarios
        $ibccontope1=$topesalarios;
    }
    else{ // else si el ibcsalario tiene valor y es menor que los 25 salarios

        if($diaslabor<$diasbase){ // si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son menos que los del mes

            if($diaslabor==0){
                $ibcsadi=0;
            }
            else{
                $ibcsadi=($ibcsalario1/$diaslabor);
            }

            if(($ibcsadi)>($salariominimo/$diasbase)){ // si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son menos que los del mes y el ibcsalario es mas que el minimo
                $ibccontope1=$ibcsalario1;
            }
            else{ // else si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son menos que los del mes y el ibcsalario es menos que el minimo
                $ibccontope1=(($salariominimo/$diasbase)*$diaslabor);
            }
        }
        else{ // else si el ibcsalario tiene valor y es menor que los 25 salarios y dias laborados son los del mes
            if($ibcsalario1<$salariominimo){
                $ibccontope1=$salariominimo;
            }
            else{
                $ibccontope1=$ibcsalario1;
            }
        }
    }
}
else{ //else si el ibcsalario no tiene valor
    $ibccontope1=0;
}

/*
    Fin Validación ibc e ibc con tope novedades
*/
//-----------------------------------------------------------------------------------------------//

//-------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------DEDUCIDOS-------------------------------------------------------//
//-------------------------------------------------------------------------------------------------------------------------//

//ojo aca, estos valores están estáticos, pero deberían estar almacenados no se donde
$multdescuentosalud=0.04;
$multdescuentopension=0.04;
//ojo aca, estos valores están estáticos, pero deberían estar almacenados no se donde

$riesgosadicional = Tb_riesgo_adicional::select('rangoSalarioMin','rangoSalarioMax','porcentajeAdicional')->get();
foreach($riesgosadicional as $riesgoadicional){
    $rangoSalarioMin = $riesgoadicional->rangoSalarioMin;
    $rangoSalarioMax = $riesgoadicional->rangoSalarioMax;

    $salarioMin=$rangoSalarioMin*$salariominimo;
    $salarioMax=$rangoSalarioMax*$salariominimo;

    if(($ibccontope>=$salarioMin) && ($ibccontope<=$salarioMax)){
        $porcentajeAdicional = $riesgoadicional->porcentajeAdicional;
    }
}

$fondoSolidaridad=$ibccontope*$porcentajeAdicional;

$descuentosalud=$ibccontope*$multdescuentosalud;
$descuentopension=$ibccontope*$multdescuentopension;

$descuentosalud1=$ibccontope1*$multdescuentosalud;
$descuentopension1=$ibccontope1*$multdescuentopension;

$deducidos=$valorsindicato+$valorprestamos+$valorembargos+$valorotros+$descuentosalud+$descuentopension+$fondoSolidaridad+$valorretencion; // ejemplo calculado

$deducidos1=$valorsindicato+$valorprestamos+$valorembargos+$valorotros+$descuentosalud1+$descuentopension1+$fondoSolidaridad+$valorretencion; // ejemplo novedad

//-------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------TOTAL A PAGAR-------------------------------------------------------//
//-------------------------------------------------------------------------------------------------------------------------//

$totalapagar=$devengadoauxilio-$deducidos; // ejemplo calculado

$totalapagar1=$devengado1auxilio-$deducidos1; // ejemplo novedad

//-------------------------------------------------------------------------------------------------------------------------//

//-----------------------------------------------------PARAFISCALES--------------------------------------------------------//
//-------------------------------------------------------------------------------------------------------------------------//

if($ibccontope>(10*$salariominimo)){ // si el ibc con tope es mayor que los 10 salarios
    $aportesalud=($ibccontope*0.085);
}
else{
    $aportesalud=0;
}

$aportepension=($ibccontope*0.12);

$riesgos = Tb_niveles_riesgo::where('id','=',$vinculacionesidNivelArl)
->select('id','nivelArl','porcentajeNivelArl')->get();
foreach($riesgos as $riesgo){
    $porcentajeNivelArl = $riesgo->porcentajeNivelArl;
    }

$aportearl=($ibccontope*$porcentajeNivelArl); //valor riesgo arl segun vinculacion

if($ibccontope>(10*$salariominimo)){ // si el ibc con tope es mayor que los 10 salarios hay que preguntar si esta bien
    $aporteicbf=($ibccontope*0.03);
    $aportesena=($ibccontope*0.02);
}
else{
    $aporteicbf=0;
    $aportesena=0;
}

$cajacompensacion=($ibccontope*0.04);

$basecalculo=($ibcsalario+$auxilio);

$cesantias=($basecalculo*0.0833);

$interescesantias=($cesantias*0.12);

$primaservicios=($basecalculo*0.0833);

$vacaciones=($ibcsalario*0.0417);

$costototalmensual=$aportesalud+$aportepension+$aportearl+$aportesena+$aporteicbf+$cajacompensacion+$cesantias+$interescesantias+$primaservicios+$vacaciones+$devengadoauxilio;
//-------------------------------------------------------------------------------------------------------------------------//
    } // cierre calculo por empleado de novedades
/**/
    $tb_resumen_nomina=new Tb_resumen_nomina();
    $tb_resumen_nomina->fechaVinculacion=$vinculacionesfechaInicio;
    $tb_resumen_nomina->tipoContrato=$vinculacionestipoVinculacion;
    $tb_resumen_nomina->diasLaborados=$diaslabor;
    $tb_resumen_nomina->valordiasLaborados=$valordiaslabor;
    $tb_resumen_nomina->extrasDiurnas=$extrasdiurnas;
    $tb_resumen_nomina->valorextrasDiurnas=$valorextrasdiurnas;
    $tb_resumen_nomina->extrasNocturnas=$extrasnocturnas;
    $tb_resumen_nomina->valorextrasNocturnas=$valorextrasnocturnas;
    $tb_resumen_nomina->horasDominicales=$horasdominicales;
    $tb_resumen_nomina->valorhorasDominicales=$valorhorasdominicales;
    $tb_resumen_nomina->extrasDominicalesDiurnas=$extrasdominicalesdiurnas;
    $tb_resumen_nomina->valorextrasDominicalesDiurnas=$valorextrasdominicalesdiurnas;
    $tb_resumen_nomina->extrasDominicalesNocturnas=$extrasdominicalesnocturnas;
    $tb_resumen_nomina->valorextrasDominicalesNocturnas=$valorextrasdominicalesnocturnas;
    $tb_resumen_nomina->recargos=$horasrecargos;
    $tb_resumen_nomina->valorrecargos=$recargos;
    $tb_resumen_nomina->totalhorasExtras=$horasextras;
    $tb_resumen_nomina->totalrecargos=$valorhorasrecargos;
    $tb_resumen_nomina->totalExtrasyRecargos=$valorhorasrecargos+$horasextras;
    $tb_resumen_nomina->primaExtralegal=$valorprimaextralegal;
    $tb_resumen_nomina->bonificaciones=$valorbonificaciones;
    $tb_resumen_nomina->comisiones=$valorcomisiones;
    $tb_resumen_nomina->viaticos=$valorviaticos;
    $tb_resumen_nomina->noFactorSalarial=$valornofactorsalarial;
    $tb_resumen_nomina->devengadoSinAuxilio=$devengados;
    $tb_resumen_nomina->auxilio=$auxilio;
    $tb_resumen_nomina->devengadoConAuxilio=$devengadoauxilio;
    $tb_resumen_nomina->ibcSalario=$ibcsalario;
    $tb_resumen_nomina->ibcConTope=$ibccontope;
    $tb_resumen_nomina->descuentoSalud=$descuentosalud;
    $tb_resumen_nomina->descuentoPension=$descuentopension;

    $tb_resumen_nomina->fondoSolidaridad=$fondoSolidaridad;
    $tb_resumen_nomina->retencion=$valorretencion;

    $tb_resumen_nomina->sindicato=$valorsindicato;
    $tb_resumen_nomina->prestamos=$valorprestamos;
    $tb_resumen_nomina->otros=$valorotros;
    $tb_resumen_nomina->totalDeducido=$deducidos;
    $tb_resumen_nomina->totalPagar=$totalapagar;
    $tb_resumen_nomina->aporteSalud=$aportesalud;
    $tb_resumen_nomina->aportePension=$aportepension;
    $tb_resumen_nomina->aporteArl=$aportearl;
    $tb_resumen_nomina->aporteIcbf=$aporteicbf;
    $tb_resumen_nomina->aporteSena=$aportesena;
    $tb_resumen_nomina->aporteCaja=$cajacompensacion;
    $tb_resumen_nomina->cesantias=$cesantias;
    $tb_resumen_nomina->interesesCesantias=$interescesantias;
    $tb_resumen_nomina->primaServicios=$primaservicios;
    $tb_resumen_nomina->vacaciones=$vacaciones;
    $tb_resumen_nomina->costoTotalMensual=$costototalmensual;
    $tb_resumen_nomina->sueldoBasicoMensual=$sueldobase;
    $tb_resumen_nomina->idEmpleado=$empleadonovedadid;
    $tb_resumen_nomina->idNomina=$nominaid;
    $tb_resumen_nomina->save();

} //cierre foreach vinculaciones

$tb_cierre_nomina=Tb_nomina::findOrFail($nominaid);
$tb_cierre_nomina->estado=0;
$tb_cierre_nomina->save();

 Log::info($nominaid);

    }
}
