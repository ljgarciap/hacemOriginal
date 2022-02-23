<?php

namespace App\Exports;

use App\Tb_resumen_nomina;
use App\Tb_vinculaciones;
use App\Tb_niveles_riesgo;
use App\Tb_Empleado;
use App\Tb_perfil;
use App\Tb_proceso;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class DetalleNominaFija implements FromCollection,WithHeadings,WithEvents,ShouldAutoSize,WithDrawings,WithStrictNullComparison,WithTitle
{
    use Exportable;
    
    private $date;
    private $idNomina;

    public function headings(): array
    {
        return [
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [''],
            [
            'Codigo',
            'Documento',
            'Nombres y Apellidos',
            'Cargo',
            'Nivel Arl',
            'Porcentaje Arl',
            'Fecha Vinculación',
            'Tipo Contrato',
            'Sueldo Basico Mensual',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'Total Horas Extras',
            'Total Recargos',
            'Total Extras y Recargos',
            'Prima Extra Legal',
            'Bonificaciones',
            'Comisiones',
            'Viaticos',
            'Conceptos Que No Son Factor Salarial',
            'Total Devengado Sin Auxilio Transporte',
            'Auxilio Transporte',
            'Total Devengado Con Auxilio Transporte',
            'Ibc Salario',
            'Ibc Con Tope',
            'Descuento A Salud',
            'Descuento A Pensión',
            'Fondo De Solidaridad Aplicar Tabla',
            'Retención En La Fuente Aplicar Tabla',
            'Sindicato',
            'Préstamos',
            'Otros',
            'Total Deducido',
            'Total a Pagar',
            'Aporte Salud',
            'Aporte Pensión',
            'Aporte Arl',
            'Aporte Sena',
            'Aporte ICBF',
            'Aporte Caja',
            'Cesantias',
            'Intereses Cesantias',
            'Prima Servicios',
            'Vacaciones',
            'Costo Total Mensual',
            ],
            [' '],
        ];
    }
    public function title(): string{
        return 'Nomina';
    }

    public function __construct($idNomina=NULL){
        $this->idNomina=$idNomina;
    }

    public function collection()
    {
        if(is_null($this->idNomina)){
        $detalles = Tb_resumen_nomina::join('tb_empleado','tb_resumen_nomina.idEmpleado','=','tb_empleado.id')
         ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
         ->join("tb_vinculaciones","tb_empleado.id","=","tb_vinculaciones.idEmpleado")
         ->join("tb_niveles_riesgo","tb_vinculaciones.idNivelArl",'=',"tb_niveles_riesgo.id")
         ->select('tb_resumen_nomina.id','tb_empleado.documento','tb_empleado.nombre as nombreEmpleado','tb_perfil.perfil','tb_niveles_riesgo.nivelArl','tb_niveles_riesgo.porcentajeNivelArl',
         'tb_resumen_nomina.fechaVinculacion','tb_resumen_nomina.tipoContrato','tb_resumen_nomina.sueldoBasicoMensual','tb_resumen_nomina.diasLaborados','tb_resumen_nomina.valorDiasLaborados',
         'tb_resumen_nomina.extrasDiurnas','tb_resumen_nomina.valorextrasDiurnas','tb_resumen_nomina.extrasNocturnas','tb_resumen_nomina.valorextrasNocturnas','tb_resumen_nomina.horasDominicales',
         'tb_resumen_nomina.valorhorasDominicales','tb_resumen_nomina.extrasDominicalesDiurnas','tb_resumen_nomina.valorextrasDominicalesDiurnas','tb_resumen_nomina.extrasDominicalesNocturnas',
         'tb_resumen_nomina.valorextrasDominicalesNocturnas','tb_resumen_nomina.recargos','tb_resumen_nomina.valorrecargos','tb_resumen_nomina.totalhorasExtras','tb_resumen_nomina.totalrecargos',
         'tb_resumen_nomina.totalExtrasyRecargos','tb_resumen_nomina.primaExtralegal','tb_resumen_nomina.bonificaciones','tb_resumen_nomina.comisiones','tb_resumen_nomina.viaticos','tb_resumen_nomina.noFactorSalarial',
         'tb_resumen_nomina.devengadoSinAuxilio','tb_resumen_nomina.auxilio','tb_resumen_nomina.devengadoConAuxilio','tb_resumen_nomina.ibcSalario','tb_resumen_nomina.ibcConTope','tb_resumen_nomina.descuentoSalud',
         'tb_resumen_nomina.descuentoPension','tb_resumen_nomina.fondoSolidaridad','tb_resumen_nomina.retencion','tb_resumen_nomina.sindicato','tb_resumen_nomina.prestamos','tb_resumen_nomina.otros','tb_resumen_nomina.totalDeducido','tb_resumen_nomina.totalPagar','tb_resumen_nomina.aporteSalud',
         'tb_resumen_nomina.aportePension','tb_resumen_nomina.aporteArl','tb_resumen_nomina.aporteSena','tb_resumen_nomina.aporteIcbf','tb_resumen_nomina.aporteCaja','tb_resumen_nomina.cesantias','tb_resumen_nomina.interesesCesantias','tb_resumen_nomina.primaServicios',
         'tb_resumen_nomina.vacaciones','tb_resumen_nomina.costoTotalMensual',
         DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido) as nombreEmpleado'))
         ->orderBy('id','asc')
         ->get();
        }
        else{
            $detalles = Tb_resumen_nomina::join('tb_empleado','tb_resumen_nomina.idEmpleado','=','tb_empleado.id')
            ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
            ->join("tb_vinculaciones","tb_empleado.id","=","tb_vinculaciones.idEmpleado")
            ->join("tb_niveles_riesgo","tb_vinculaciones.idNivelArl",'=',"tb_niveles_riesgo.id")
            ->select('tb_resumen_nomina.id','tb_empleado.documento','tb_empleado.nombre as nombreEmpleado','tb_perfil.perfil','tb_niveles_riesgo.nivelArl','tb_niveles_riesgo.porcentajeNivelArl',
            'tb_resumen_nomina.fechaVinculacion','tb_resumen_nomina.tipoContrato','tb_resumen_nomina.sueldoBasicoMensual','tb_resumen_nomina.diasLaborados','tb_resumen_nomina.valorDiasLaborados',
            'tb_resumen_nomina.extrasDiurnas','tb_resumen_nomina.valorextrasDiurnas','tb_resumen_nomina.extrasNocturnas','tb_resumen_nomina.valorextrasNocturnas','tb_resumen_nomina.horasDominicales',
            'tb_resumen_nomina.valorhorasDominicales','tb_resumen_nomina.extrasDominicalesDiurnas','tb_resumen_nomina.valorextrasDominicalesDiurnas','tb_resumen_nomina.extrasDominicalesNocturnas',
            'tb_resumen_nomina.valorextrasDominicalesNocturnas','tb_resumen_nomina.recargos','tb_resumen_nomina.valorrecargos','tb_resumen_nomina.totalhorasExtras','tb_resumen_nomina.totalrecargos',
            'tb_resumen_nomina.totalExtrasyRecargos','tb_resumen_nomina.primaExtralegal','tb_resumen_nomina.bonificaciones','tb_resumen_nomina.comisiones','tb_resumen_nomina.viaticos','tb_resumen_nomina.noFactorSalarial',
            'tb_resumen_nomina.devengadoSinAuxilio','tb_resumen_nomina.auxilio','tb_resumen_nomina.devengadoConAuxilio','tb_resumen_nomina.ibcSalario','tb_resumen_nomina.ibcConTope','tb_resumen_nomina.descuentoSalud',
            'tb_resumen_nomina.descuentoPension','tb_resumen_nomina.fondoSolidaridad','tb_resumen_nomina.retencion','tb_resumen_nomina.sindicato','tb_resumen_nomina.prestamos','tb_resumen_nomina.otros','tb_resumen_nomina.totalDeducido','tb_resumen_nomina.totalPagar','tb_resumen_nomina.aporteSalud',
            'tb_resumen_nomina.aportePension','tb_resumen_nomina.aporteArl','tb_resumen_nomina.aporteSena','tb_resumen_nomina.aporteIcbf','tb_resumen_nomina.aporteCaja','tb_resumen_nomina.cesantias','tb_resumen_nomina.interesesCesantias','tb_resumen_nomina.primaServicios',
            'tb_resumen_nomina.vacaciones','tb_resumen_nomina.costoTotalMensual',
            DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido) as nombreEmpleado'))
            ->orderBy('id','asc')
            ->get();
        }
        return $detalles;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $cellRange = 'C2';
                $event->sheet->getDelegate()->setCellValue('C2', 'AÑO')->getStyle($cellRange)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);

                $cellRange2 = 'D2';
                $event->sheet->getDelegate()->setCellValue('D2', '2021')->getStyle($cellRange2)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange2)->getFont()->setBold(true);
                
                $cellRange_1 = 'C4';
                $event->sheet->getDelegate()->setCellValue('C4', 'SALARIO MINIMO')->getStyle($cellRange_1)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange_1)->getFont()->setBold(true);

                $cellRange_2 = 'D4';
                $event->sheet->getDelegate()->setCellValue('D4', '$ 908,526')->getStyle($cellRange_2)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange_2)->getFont()->setBold(true);

                $cellRange_3 = 'C5';
                $event->sheet->getDelegate()->setCellValue('C5', 'AUXILIO DE TRANSPORTE')->getStyle($cellRange_3)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange_3)->getFont()->setBold(true);

                $cellRange_4 = 'D5';
                $event->sheet->getDelegate()->setCellValue('D5', '$ 106,454')->getStyle($cellRange_4)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange_4)->getFont()->setBold(true);

                $cellRange3 = 'A7:G10';
                $event->sheet->getDelegate()->mergeCells('A7:G10');
                $event->sheet->getDelegate()->getStyle('A7:G10')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A7', '')->getStyle($cellRange3)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');
                
                $cellRange4 = 'H7:BD7';
                $event->sheet->getDelegate()->mergeCells('H7:BD7');
                $event->sheet->getDelegate()->getStyle('H7:BD7')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('H7', 'SERVICIO NACIONAL DE APRENDIZAJE - SENA')->getStyle($cellRange4)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange4)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange5 = 'H8:BD8';
                $event->sheet->getDelegate()->mergeCells('H8:BD8');
                $event->sheet->getDelegate()->getStyle('H8:BD8')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('H8', 'REGIONAL SANTANDER')->getStyle($cellRange5)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange5)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange6 = 'H9:BD9';
                $event->sheet->getDelegate()->mergeCells('H9:BD9');
                $event->sheet->getDelegate()->getStyle('H9:BD9')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('H9', 'CENTRO INDUSTRIAL DEL DISEÑO Y LA MANUFACTURA - CIDM')->getStyle($cellRange6)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange6)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange7 = 'H10:BD10';
                $event->sheet->getDelegate()->mergeCells('H10:BD10');
                $event->sheet->getDelegate()->getStyle('H10:BD10')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('H10', 'PROYECTO SENNOVA "ESTRATEGIA INTEGRAL PARA EL APRENDIZAJE DEL CÁLCULO DE COSTOS DE PRODUCCIÓN APLICADO A LAS MICROEMPRESAS DEL SISTEMA MODA EN FLORIDABLANCA" - 2020')->getStyle($cellRange7)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange7)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange8 = 'A11:H12';
                $event->sheet->getDelegate()->mergeCells('A11:H12');
                $event->sheet->getDelegate()->getStyle('A11:H12')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A11', 'INFORMACIÓN')->getStyle($cellRange8)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange8)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('CBF4F1');

                $cellRange9 = 'A13:H15'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange9)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange9)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('CBF4F1');
                 
                $cellRange10 = 'I11:AH12';
                $event->sheet->getDelegate()->mergeCells('I11:AH12');
                $event->sheet->getDelegate()->getStyle('I11:AH12')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('I11', 'NOVEDADES')->getStyle($cellRange10)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange10)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF6502');

                $cellRangeA10 = 'AI11:AJ12';
                $event->sheet->getDelegate()->mergeCells('AI11:AJ12');
                $event->sheet->getDelegate()->getStyle('AI11:AJ12')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('AI11', 'IBC')->getStyle($cellRangeA10)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeA10)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D9D9D9');

                $cellRangeB10 = 'AK11:AR12';
                $event->sheet->getDelegate()->mergeCells('AK11:AR12');
                $event->sheet->getDelegate()->getStyle('AK11:AR12')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('AK11', 'DEDUCIDO')->getStyle($cellRangeB10)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeB10)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D7BBEB');

                $cellRangeC10 = 'AS11:AS15';
                $event->sheet->getDelegate()->mergeCells('AS11:AS15');
                $event->sheet->getDelegate()->getStyle('AS11:AS15')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('AS11', 'Total A Pagar')->getStyle($cellRangeC10)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeC10)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('8BC8FF');

                $cellRangeD10 = 'AT11:AY12';
                $event->sheet->getDelegate()->mergeCells('AT11:AY12');
                $event->sheet->getDelegate()->getStyle('AT11:AY12')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('AT11', 'SEGURIDAD SOCIAL Y PARAFISCALES DEL EMPLEADOR')->getStyle($cellRangeD10)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeD10)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B6');

                $cellRangeE10 = 'AZ11:BC12';
                $event->sheet->getDelegate()->mergeCells('AZ11:BC12');
                $event->sheet->getDelegate()->getStyle('AZ11:BC12')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('AZ11', 'PROVISIÓN PRESTACIONES SOCIALES')->getStyle($cellRangeE10)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeE10)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B6');

                $cellRangeF10 = 'BD11:BD12';
                $event->sheet->getDelegate()->mergeCells('BD11:BD12');
                $event->sheet->getDelegate()->getStyle('BD11:BD12')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('BD11', 'COSTO TOTAL')->getStyle($cellRangeF10)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeF10)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('85E2EB');

                $cellRange11 = 'I13:AH15'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange11)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange11)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeA11 = 'AI13:AJ15'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRangeA11)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeA11)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D9D9D9');

                $cellRangeB11 = 'AK13:AR15'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRangeB11)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeB11)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('D7BBEB');

                $cellRangeC11 = 'AT13:AY15'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRangeC11)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeC11)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFEBE0');

                $cellRangeD11 = 'AZ13:BC15'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRangeD11)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeD11)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFEBE0');

                $cellRangeE11 = 'BD13:BD15'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRangeE11)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRangeE11)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('85E2EB');

                $cellRange12 = 'J13:W13';
                $event->sheet->getDelegate()->mergeCells('J13:W13');
                $event->sheet->getDelegate()->getStyle('J13')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('J13', 'HORAS EXTRAS Y RECARGOS')->getStyle($cellRange12)->getFont()->setSize(11)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange12)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange13 = 'J14:K14';
                $event->sheet->getDelegate()->mergeCells('J14:K14');
                $event->sheet->getDelegate()->getStyle('J14:K14')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('J14', 'Días Laborados')->getStyle($cellRange13)->getFont()->setSize(11)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange13)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8'); 

                $cellRangeA13 = 'J15';
                $event->sheet->getDelegate()->setCellValue('J15', 'CANT.')->getStyle($cellRangeA13)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeA13)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeB13 = 'K15';
                $event->sheet->getDelegate()->setCellValue('K15', 'VALOR')->getStyle($cellRangeB13)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeB13)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRange14 = 'L14:M14';
                $event->sheet->getDelegate()->mergeCells('L14:M14');
                $event->sheet->getDelegate()->getStyle('L14:M14')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('L14', 'Hora Extra Diurna')->getStyle($cellRange14)->getFont()->setSize(11)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange14)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeA14 = 'L15';
                $event->sheet->getDelegate()->setCellValue('L15', 'CANT.')->getStyle($cellRangeA14)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeA14)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeB14 = 'M15';
                $event->sheet->getDelegate()->setCellValue('M15', 'VALOR')->getStyle($cellRangeB14)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeB14)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRange15 = 'N14:O14';
                $event->sheet->getDelegate()->mergeCells('N14:O14');
                $event->sheet->getDelegate()->getStyle('N14:O14')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('N14', 'Hora Extra Nocturna')->getStyle($cellRange15)->getFont()->setSize(11)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange15)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeA15 = 'N15';
                $event->sheet->getDelegate()->setCellValue('N15', 'CANT.')->getStyle($cellRangeA15)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeA15)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeB15 = 'O15';
                $event->sheet->getDelegate()->setCellValue('O15', 'VALOR')->getStyle($cellRangeB15)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeB15)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRange16 = 'P14:Q14';
                $event->sheet->getDelegate()->mergeCells('P14:Q14');
                $event->sheet->getDelegate()->getStyle('P14:Q14')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('P14', 'Hora Dominical O Festiva')->getStyle($cellRange16)->getFont()->setSize(11)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange16)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeA16 = 'P15';
                $event->sheet->getDelegate()->setCellValue('P15', 'CANT.')->getStyle($cellRangeA16)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeA16)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeB16 = 'Q15';
                $event->sheet->getDelegate()->setCellValue('Q15', 'VALOR')->getStyle($cellRangeB16)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeB16)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRange17 = 'R14:S14';
                $event->sheet->getDelegate()->mergeCells('R14:S14');
                $event->sheet->getDelegate()->getStyle('R14:S14')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('R14', 'Hora Dominical O Festiva Diurna')->getStyle($cellRange17)->getFont()->setSize(11)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange17)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeA17 = 'R15';
                $event->sheet->getDelegate()->setCellValue('R15', 'CANT.')->getStyle($cellRangeA17)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeA17)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeB17 = 'S15';
                $event->sheet->getDelegate()->setCellValue('S15', 'VALOR')->getStyle($cellRangeB17)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeB17)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRange18 = 'T14:U14';
                $event->sheet->getDelegate()->mergeCells('T14:U14');
                $event->sheet->getDelegate()->getStyle('T14:U14')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('T14', 'Hora Dominical O Festiva Nocturna')->getStyle($cellRange18)->getFont()->setSize(11)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange18)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeA18 = 'T15';
                $event->sheet->getDelegate()->setCellValue('T15', 'CANT.')->getStyle($cellRangeA18)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeA18)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeB18 = 'U15';
                $event->sheet->getDelegate()->setCellValue('U15', 'VALOR')->getStyle($cellRangeB18)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeB18)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRange19 = 'V14:W14';
                $event->sheet->getDelegate()->mergeCells('V14:W14');
                $event->sheet->getDelegate()->getStyle('V14:W14')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('V14', 'Recargo Nocturnos')->getStyle($cellRange19)->getFont()->setSize(11)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange19)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeA19 = 'V15';
                $event->sheet->getDelegate()->setCellValue('V15', 'CANT.')->getStyle($cellRangeA19)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeA19)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $cellRangeB19 = 'W15';
                $event->sheet->getDelegate()->setCellValue('W15', 'VALOR')->getStyle($cellRangeB19)->getFont()->setSize(10)->setBold(false);
                $event->sheet->getDelegate()->getStyle($cellRangeB19)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('F2E1B8');

                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A7:G10','thin')->applyFromArray($styleArray);

                $styleArray1 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('H7:BD10','thin')->applyFromArray($styleArray1);

                $styleArray2 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A11:H12','thin')->applyFromArray($styleArray2);

                $styleArray3 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('I11:BD12','thin')->applyFromArray($styleArray3);

                $styleArray4 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A13:H15','thin')->applyFromArray($styleArray4);

                $styleArray5 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('I11:AH15','thin')->applyFromArray($styleArray5);

                $styleArray6 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('AI11:AJ15','thin')->applyFromArray($styleArray6);

                $styleArray7 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('AK11:AR15','thin')->applyFromArray($styleArray7);

                $styleArray8 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('AS11:AS15','thin')->applyFromArray($styleArray8);

                $styleArray9 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('AT11:AY15','thin')->applyFromArray($styleArray9);

                $styleArray10 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('AT11:AY15','thin')->applyFromArray($styleArray10);

                $styleArray11 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('AZ11:BC15','thin')->applyFromArray($styleArray11);

                $styleArray12 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('BD11:BD15','thin')->applyFromArray($styleArray12);

                $styleArray13 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('C2:D2','thin')->applyFromArray($styleArray13);

                $styleArray14 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('C4:E5','thin')->applyFromArray($styleArray14);
            },
        ];
    }
   public function autoFitColumnWidthToContent($sheet, $fromCol, $toCol) { if (empty($toCol) ) {
           
        $toCol = $sheet->getColumnDimension($sheet->getHighestColumn())->getColumnIndex();
        } 
        for($i = $fromCol; $i <= $toCol; $i++) { 
            $sheet->getColumnDimension($i)->setAutoSize(true); 
           }
           $sheet->calculateColumnWidths(); 
       }

   public function drawings()
   {
       $drawing = new Drawing();
       $drawing->setName('Logo');
       $drawing->setDescription('Logo Naranja SENA');
       $drawing->setPath(public_path('/img/logosena.png'));
       $drawing->setHeight(65);
       $drawing->setCoordinates('D7');

       return $drawing;
   }
}
