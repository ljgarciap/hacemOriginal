<?php

namespace App\Exports;

use App\Tb_resumen_nomina;
use App\Tb_vinculaciones;
use App\Tb_niveles_riesgo;
use App\Empleado;
use App\perfil;
use App\proceso;
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
    
    public function headings(): array
    {
        return [
            [' '],
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
            'Dias Laborados',
            'Valor Dias Laborados',
            'Hora Extra Diurna',
            'Valor Extra Diurna',
            'Hora Extra Nocturna',
            'Valor Extra Nocturna',
            'Hora Dominical',
            'Valor Hora Dominical',
            'Hora Extra Dominical Diurna',
            'Valor Extra Dominical Diurno',
            'Hora Extra Dominical Nocturno',
            'Valor Extra Dominical Nocturno',
            'Recargos',
            'Valor Recargos',
            'Total Horas Extras',
            'Total Recargos',
            'Total Extra y Recargos',
            'Prima Extra Legal',
            'Bonificaciones',
            'Comisiones',
            'Viaticos',
            'No Factor Salarial',
            'Devengado Sin Auxilio',
            'Auxilio',
            'Devengado Con Auxilio',
            'Ibc Salario',
            'Ibc Con Tope',
            'Descuento Salud',
            'Descuento Pensión',
            'Fondo Solidaridad',
            'Retención',
            'Sindicato',
            'Prestamos',
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
            ]
        ];
    }
    public function forDate($date){
        $this->date = $date;
        return $this;
    }
    public function title(): string{
        return "Nomina Fija";
    }
    public function collection()
    {
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
                $event->sheet->getDelegate()->setCellValue('D2', '2020')->getStyle($cellRange2)->getFont()->setSize(11);
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
                $event->sheet->getDelegate()->getStyle('A7')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A7', '')->getStyle($cellRange3)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');
                
                $cellRange4 = 'H7:BD7';
                $event->sheet->getDelegate()->mergeCells('H7:BD7');
                $event->sheet->getDelegate()->getStyle('H7')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('H7', 'SERVICIO NACIONAL DE APRENDIZAJE - SENA')->getStyle($cellRange4)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange4)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange5 = 'H8:BD8';
                $event->sheet->getDelegate()->mergeCells('H8:BD8');
                $event->sheet->getDelegate()->getStyle('H8')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('H8', 'REGIONAL SANTANDER')->getStyle($cellRange5)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange5)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange6 = 'H9:BD9';
                $event->sheet->getDelegate()->mergeCells('H9:BD9');
                $event->sheet->getDelegate()->getStyle('H9')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('H9', 'CENTRO INDUSTRIAL DEL DISEÑO Y LA MANUFACTURA - CIDM')->getStyle($cellRange6)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange6)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange7 = 'H10:BD10';
                $event->sheet->getDelegate()->mergeCells('H10:BD10');
                $event->sheet->getDelegate()->getStyle('H10')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('H10', 'PROYECTO SENNOVA "ESTRATEGIA INTEGRAL PARA EL APRENDIZAJE DEL CÁLCULO DE COSTOS DE PRODUCCIÓN APLICADO A LAS MICROEMPRESAS DEL SISTEMA MODA EN FLORIDABLANCA" - 2020')->getStyle($cellRange7)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange7)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');


                $cellRange8 = 'A11:H12';
                $event->sheet->getDelegate()->mergeCells('A11:H12');
                $event->sheet->getDelegate()->getStyle('A11')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A11', 'INFORMACIÓN')->getStyle($cellRange8)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange8)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('CBF4F1');

                $cellRange9 = 'A13:H13'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange9)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange9)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange9)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('CBF4F1');
                
                
                $cellRange10 = 'I11:BD12';
                $event->sheet->getDelegate()->mergeCells('I11:BD12');
                $event->sheet->getDelegate()->getStyle('I11')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('I11', 'NOVEDADES')->getStyle($cellRange10)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange10)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF6502');

                $cellRange11 = 'I13:BD13'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange11)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange11)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange11)->getFill()
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
                
                $event->sheet->getStyle('A7:G10')->applyFromArray($styleArray);

                $styleArray1 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('H7:BD10')->applyFromArray($styleArray1);

                $styleArray2 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A11:H12')->applyFromArray($styleArray2);

                $styleArray3 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('I11:BD12')->applyFromArray($styleArray3);

                $styleArray4 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A13:H13')->applyFromArray($styleArray4);

                $styleArray5 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('H13:BD13')->applyFromArray($styleArray5);

                $styleArray6 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('C2:D2')->applyFromArray($styleArray6);

                $styleArray7 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('C4:E5')->applyFromArray($styleArray7);
            },
        ];
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
