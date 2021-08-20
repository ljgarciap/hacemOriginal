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

class CalculaNominaDestajo implements ShouldQueue
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
    // Cálculo de nómina destajo
    //---------------------------------------------------------------------------------------------------//
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

            //estos vienen de la tabla factores nomina
            $factores = Tb_factores_nomina::where('id','=','1')
            ->select('id','extraDiurna','extraNocturna','horaDominical','festivaDiurna','festivaNocturna','recargos','minimolegal','auxilio')->get();

            foreach($factores as $totalg){
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

        //Distinct de novedades para sacar los empleados involucrados

        $empleadonovedades = Tb_novedades::where('idNomina','=',$nominaid)->groupby('idEmpleado')->distinct()->select('idEmpleado')->get();

         //dentro de este foreach voy a sacar los datos de los empleados que hacen parte de la nómina para buscar sus novedades
        foreach($empleadonovedades as $empleadonovedad){ //abre foreach novedades

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

            // seccion descuentos
            $valortareas=0;
            $cantidadtareas=0;
            $valorvacaciones=0;
            $valorprima=0;
            $valorcesantias=0;
            $valorintereses=0;
            $valorsalud=0;
            $valorpension=0;
            $valorarl=0;
            $valorcaja=0;
            $valorauxilio=0;
            $valoreps=0;
            $valorpension=0;
            $acumuladovaloreps=0;
            $acumuladovalorpension=0;
            $prestamos=0; // valor prestamos
            $valorprestamos=0;
            $otros=0; // valor otros
            $valorotros=0;
            $descuentosalud=0;
            $descuentopension=0;
            $fondoSolidaridad=0;
            $valorretencion=0;
            $retencion=0;
            //hasta aca vienen de la tabla novedades

            //estos vienen de la tabla novedades
            $sueldobasico=0;

            $novedadesbase = Tb_novedades::where('tb_novedades.idEmpleado','=',$empleadonovedadid)
            ->where('tb_novedades.idNomina','=',$nominaid)
            ->where('tb_novedades.concepto','=','1')->get(); //De aca me voy a traer los de la nomina sin liquidar, ojo tengo que ir cambiando el valor de ella

            foreach($novedadesbase as $guianovedadesbase){ //apertura calculo por empleado de novedades
                $novedadesvalorbase = $guianovedadesbase->valor;
                $sueldobasico=$sueldobasico+$novedadesvalorbase;
            }


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


        //ojo aca, estos valores están estáticos, pero deberían estar almacenados no se donde
        $multdescuentosalud=0.04;
        $multdescuentopension=0.04;
        //ojo aca, estos valores están estáticos, pero deberían estar almacenados no se donde

            //para destajo tengo en cuenta tipologias de entradas: 3- sin provision 4- solo liquidacion 5- solo parafiscales 6-con todo
            //para destajo tengo en cuenta tipologias de salidas: 2- salida

            if($novedadesconcepto==1 && $novedadestipologia==3){
                $valoreps=0;
                $valorpension=0;

                $valortareas=$valortareas+$novedadesvalor;
                $cantidadtareas=$cantidadtareas+$novedadescantidad;
                $acumuladovaloreps=$acumuladovaloreps+$valoreps;
                $acumuladovalorpension=$acumuladovalorpension+$valorpension;
            }
            else if($novedadesconcepto==1 && $novedadestipologia==4){

                $valoreps=$novedadesvalor*$multdescuentosalud;
                $valorpension=$novedadesvalor*$multdescuentopension;

                $valortareas=$valortareas+$novedadesvalor;
                $cantidadtareas=$cantidadtareas+$novedadescantidad;
                $acumuladovaloreps=$acumuladovaloreps+$valoreps;
                $acumuladovalorpension=$acumuladovalorpension+$valorpension;
            }
            else if($novedadesconcepto==8){
                $valorauxilio=$novedadesvalor;
            }
            else if($novedadesconcepto==50){
                $retencion=$retencion+$novedadescantidad;
                $valorretencion=$valorretencion+$novedadesvalor;
            }
            else if($novedadesconcepto==52){
                $prestamos=$prestamos+$novedadescantidad;
                $valorprestamos=$valorprestamos+$novedadesvalor;
            }
            else if($novedadesconcepto==54){
                $otros=$otros+$novedadescantidad;
                $valorotros=$valorotros+$novedadesvalor;
            }

        //-------------------------------------------------------------------------------------------------------------------------//
        $devengados=($sueldobasico);
        //-------------------------------------------------------------------------------------------------------------------------//

        if($valorauxilio==0){
            if(($sueldobasico<=(2*$salariominimo)) && ($sueldobasico>=$salariominimo)){
                $auxilio=intval($auxilioley);
            }
            else{
                $auxilio=0;
            }
        }
        else{
            $auxilio=$valorauxilio;
        }

        $devengadoauxilio=($devengados+$auxilio); // calculado
        $ibcsalario=($devengados); // calculado
        /*
            Validación ibc e ibc con tope calculado
        */

        if($ibcsalario>0){ //si el ibcsalario tiene valor
            if($ibcsalario>$topesalarios){ // si el ibcsalario tiene valor y es mayor que los 25 salarios
                $ibccontope=$topesalarios;
            }
            else{ // else si el ibcsalario tiene valor y es menor que los 25 salarios
                    if($ibcsalario<$salariominimo){
                        $ibccontope=$salariominimo;
                    }
                    else{
                        $ibccontope=$ibcsalario;
                    }
            }
        }
        else{ //else si el ibcsalario no tiene valor
            $ibccontope=0;
        }

        /*
            Fin Validación ibc e ibc con tope calculado
        */

        //-------------------------------------------------------------------------------------------------------------------------//
        //---------------------------------------------------------DEDUCIDOS-------------------------------------------------------//
        //-------------------------------------------------------------------------------------------------------------------------//

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

        //$descuentosalud=$ibccontope*$multdescuentosalud;
        //$descuentopension=$ibccontope*$multdescuentopension;

        $descuentosalud=$acumuladovaloreps;
        $descuentopension=$acumuladovalorpension;

        $deducidos=$valorprestamos+$valorotros+$descuentosalud+$descuentopension; // ejemplo calculado
        //-------------------------------------------------------------------------------------------------------------------------//

        //-----------------------------------------------------TOTAL A PAGAR-------------------------------------------------------//
        //-------------------------------------------------------------------------------------------------------------------------//

        $totalapagar=$devengadoauxilio-$deducidos; // ejemplo calculado
        //-------------------------------------------------------------------------------------------------------------------------//

        //-----------------------------------------------------PARAFISCALES--------------------------------------------------------//
        //-------------------------------------------------------------------------------------------------------------------------//

        if($ibccontope>(10*$salariominimo)){ // si el ibc con tope es mayor que los 10 salarios
            $aportesalud=($ibccontope*8.5);
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
            $aportesena=($ibcsalario*0.02);
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
            $tb_resumen_nomina->diasLaborados=0;
            $tb_resumen_nomina->valordiasLaborados=$devengados;
            $tb_resumen_nomina->extrasDiurnas=0;
            $tb_resumen_nomina->valorextrasDiurnas=0;
            $tb_resumen_nomina->extrasNocturnas=0;
            $tb_resumen_nomina->valorextrasNocturnas=0;
            $tb_resumen_nomina->horasDominicales=0;
            $tb_resumen_nomina->valorhorasDominicales=0;
            $tb_resumen_nomina->extrasDominicalesDiurnas=0;
            $tb_resumen_nomina->valorextrasDominicalesDiurnas=0;
            $tb_resumen_nomina->extrasDominicalesNocturnas=0;
            $tb_resumen_nomina->valorextrasDominicalesNocturnas=0;
            $tb_resumen_nomina->recargos=0;
            $tb_resumen_nomina->valorrecargos=0;
            $tb_resumen_nomina->totalhorasExtras=0;
            $tb_resumen_nomina->totalrecargos=0;
            $tb_resumen_nomina->totalExtrasyRecargos=0;
            $tb_resumen_nomina->primaExtralegal=0;
            $tb_resumen_nomina->bonificaciones=0;
            $tb_resumen_nomina->comisiones=0;
            $tb_resumen_nomina->viaticos=0;
            $tb_resumen_nomina->noFactorSalarial=0;
            $tb_resumen_nomina->devengadoSinAuxilio=$devengados;
            $tb_resumen_nomina->auxilio=$auxilio;
            $tb_resumen_nomina->devengadoConAuxilio=$devengadoauxilio;
            $tb_resumen_nomina->ibcSalario=$ibcsalario;
            $tb_resumen_nomina->ibcConTope=$ibccontope;
            $tb_resumen_nomina->descuentoSalud=$descuentosalud;
            $tb_resumen_nomina->descuentoPension=$descuentopension;

            $tb_resumen_nomina->fondoSolidaridad=$fondoSolidaridad;
            $tb_resumen_nomina->retencion=$valorretencion;

            $tb_resumen_nomina->sindicato=0;
            $tb_resumen_nomina->prestamos=$valorprestamos;
            $tb_resumen_nomina->otros=$valorotros;
            $tb_resumen_nomina->totalDeducido=$deducidos;
            $tb_resumen_nomina->totalPagar=$totalapagar;
            $tb_resumen_nomina->aporteSalud=$aportesalud;
            $tb_resumen_nomina->aportePension=$aportepension;
            $tb_resumen_nomina->aporteArl=$aportearl;
            $tb_resumen_nomina->aporteSena=$aportesena;
            $tb_resumen_nomina->aporteCaja=$cajacompensacion;
            $tb_resumen_nomina->cesantias=$cesantias;
            $tb_resumen_nomina->interesesCesantias=$interescesantias;
            $tb_resumen_nomina->primaServicios=$primaservicios;
            $tb_resumen_nomina->vacaciones=$vacaciones;
            $tb_resumen_nomina->costoTotalMensual=$costototalmensual;
            $tb_resumen_nomina->sueldoBasicoMensual=$sueldobasico;
            $tb_resumen_nomina->idEmpleado=$empleadonovedadid;
            $tb_resumen_nomina->idNomina=$nominaid;
            $tb_resumen_nomina->save();

        } //cierre foreach novedades

// muestra temporal de salida
/*echo "El sueldo basico es ".$sueldobasico."<br>";
echo "<hr><br>";
echo "<hr><br>";
echo "Valor descuentosalud es ".$descuentosalud."<br>";
echo "<hr><br>";
echo "Valor descuentopension es ".$descuentopension."<br>";
echo "<hr><br>";
echo "Valor devengados es ".$devengados."<br>";
echo "<hr><br>";
echo "Valor devengado con auxilio es ".$devengadoauxilio."<br>";
echo "<hr><br>";
echo "Valor deducidos es ".$deducidos."<br>";
echo "<hr><br>";
echo "Valor ibc salario ".$ibcsalario."<br>";
echo "Valor ibc tope ".$ibccontope."<br>";
echo "<hr><br>";
echo "Valor a pagar ".$totalapagar."<br>";
echo "<hr><br>";
echo "Valor total costos ".$costototalmensual."<br>";
echo "<hr><br>";*/

        $tb_cierre_nomina=Tb_nomina::findOrFail($nominaid);
        $tb_cierre_nomina->estado=0;
        $tb_cierre_nomina->save();

        Log::info($nominaid);
    }
}
