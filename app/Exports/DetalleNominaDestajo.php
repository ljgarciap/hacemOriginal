<?php

namespace App\Exports;

use App\Tb_resumen_nomina;
use App\Tb_novedades;
use App\Tb_nomina;
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

class DetalleNominaDestajo implements FromCollection,WithHeadings,WithEvents,ShouldAutoSize,WithDrawings,WithStrictNullComparison,WithTitle
{   
    use Exportable;
    
    private $date;
    private $idNomina;

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
            [
            'Operarios',
            'Cargo',
            'Pares',
            'Valor',
            'Básico',
            'Aux. transporte',
            'Total devengado',
            'IB SALARIO',
            'IBC CON TOPE',
            'Descuento salud empleado',
            'Descuento pensión empleado',
            'Total deducidos',
            'Neto a pagar',
            'Aporte Salud',
            'Aporte Pensión',
            'Aporte ARL',
            'Cajas de compensación',
            'Cesantias',
            'Intereses Cesantias',
            'Vacaciones',
            'Prima',
            'Costo total',
            'Costo unitario',
            ]
        ];
    }
    public function title(): string{
        return "Destajo";
    }

    public function __construct($idNomina=NULL){
        $this->idNomina=$idNomina;
    }

    public function collection()
    {

        if(is_null($this->idNomina)){
        $detalles = Tb_resumen_nomina::join('tb_empleado','tb_resumen_nomina.idEmpleado','=','tb_empleado.id')
        ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
        ->select('tb_empleado.nombre as nombreEmpleado','tb_perfil.perfil','tb_resumen_nomina.tipoContrato','tb_resumen_nomina.valordiasLaborados','tb_resumen_nomina.sueldoBasicoMensual',
        'tb_resumen_nomina.auxilio','tb_resumen_nomina.devengadoConAuxilio','tb_resumen_nomina.ibcSalario','tb_resumen_nomina.ibcConTope','tb_resumen_nomina.descuentoSalud',
        'tb_resumen_nomina.descuentoPension','tb_resumen_nomina.totalDeducido','tb_resumen_nomina.totalPagar','tb_resumen_nomina.aporteSalud',
        'tb_resumen_nomina.aportePension','tb_resumen_nomina.aporteArl','tb_resumen_nomina.aporteCaja','tb_resumen_nomina.cesantias','tb_resumen_nomina.interesesCesantias',
        'tb_resumen_nomina.vacaciones','tb_resumen_nomina.primaExtraLegal','tb_resumen_nomina.costoTotalMensual','tb_resumen_nomina.idNomina',
         DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido) as nombreEmpleado'))
        ->orderBy('tb_resumen_nomina.id','asc')
        ->get();
        }
        else{
            $detalles = Tb_resumen_nomina::join('tb_empleado','tb_resumen_nomina.idEmpleado','=','tb_empleado.id')
            ->join('tb_perfil','tb_empleado.idPerfil','=','tb_perfil.id')
            ->select('tb_empleado.nombre as nombreEmpleado','tb_perfil.perfil','tb_resumen_nomina.tipoContrato','tb_resumen_nomina.valordiasLaborados','tb_resumen_nomina.sueldoBasicoMensual',
            'tb_resumen_nomina.auxilio','tb_resumen_nomina.devengadoConAuxilio','tb_resumen_nomina.ibcSalario','tb_resumen_nomina.ibcConTope','tb_resumen_nomina.descuentoSalud',
            'tb_resumen_nomina.descuentoPension','tb_resumen_nomina.totalDeducido','tb_resumen_nomina.totalPagar','tb_resumen_nomina.aporteSalud',
            'tb_resumen_nomina.aportePension','tb_resumen_nomina.aporteArl','tb_resumen_nomina.aporteCaja','tb_resumen_nomina.cesantias','tb_resumen_nomina.interesesCesantias',
            'tb_resumen_nomina.vacaciones','tb_resumen_nomina.primaExtraLegal','tb_resumen_nomina.costoTotalMensual','tb_resumen_nomina.idNomina',
             DB::raw('CONCAT(tb_empleado.nombre," ",tb_empleado.apellido) as nombreEmpleado'))
            ->orderBy('tb_resumen_nomina.id','asc')
            ->where('tb_resumen_nomina.idNomina','=',$this->idNomina)
            ->get();
        }
        return $detalles;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $cellRange = 'A2:W4';
                $event->sheet->getDelegate()->mergeCells('A2:W4');
                $event->sheet->getDelegate()->getStyle('A2')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A2', '')->getStyle($cellRange)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF6502');
                
                $cellRange2 = 'A5:W5';
                $event->sheet->getDelegate()->mergeCells('A5:W5');
                $event->sheet->getDelegate()->getStyle('A5')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A5', 'CALZADO Y MARROQUINERÍA LA  BONITA SAS')->getStyle($cellRange2)->getFont()->setSize(12)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange2)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF6502');

                $cellRange3 = 'A6:A7';
                $event->sheet->getDelegate()->mergeCells('A6:A7');
                $event->sheet->getDelegate()->getStyle('A6')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A6', 'REFERENCIA')->getStyle($cellRange3)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange3 = 'B6:W7';
                $event->sheet->getDelegate()->mergeCells('B6:W7');
                $event->sheet->getDelegate()->getStyle('B6')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('B6', '')->getStyle($cellRange3)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange4 = 'A8:A9';
                $event->sheet->getDelegate()->mergeCells('A8:A9');
                $event->sheet->getDelegate()->getStyle('A8')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A8', 'CANTIDAD')->getStyle($cellRange4)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange4)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange5 = 'B8:W9';
                $event->sheet->getDelegate()->mergeCells('B8:W9');
                $event->sheet->getDelegate()->getStyle('B8')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('B8', '')->getStyle($cellRange5)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange5)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange6 = 'A10:A11';
                $event->sheet->getDelegate()->mergeCells('A10:A11');
                $event->sheet->getDelegate()->getStyle('A10')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('A10', 'ORDEN DE PRODUCCIÓN')->getStyle($cellRange6)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange6)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange7 = 'B10:W11';
                $event->sheet->getDelegate()->mergeCells('B10:W11');
                $event->sheet->getDelegate()->getStyle('B10')->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->setCellValue('B10', '')->getStyle($cellRange7)->getFont()->setSize(14)->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange7)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF');

                $cellRange8 = 'A12:W12'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange8)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange8)->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellRange8)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FDE9D9');
                
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A2:W5')->applyFromArray($styleArray);

                $styleArray1 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A6:A7')->applyFromArray($styleArray1);

                $styleArray2 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('B6:W7')->applyFromArray($styleArray2);

                $styleArray3 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A8:A9')->applyFromArray($styleArray3);

                $styleArray4 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('B8:W9')->applyFromArray($styleArray4);


                $styleArray5 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A10:A11')->applyFromArray($styleArray5);

                $styleArray6 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('B10:W11')->applyFromArray($styleArray6);

                $styleArray7 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];
                
                $event->sheet->getStyle('A12:W12')->applyFromArray($styleArray7);
            },
        ];
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo Naranja SENA');
        $drawing->setPath(public_path('/img/logosena.png'));
        $drawing->setHeight(70);
        $drawing->setCoordinates('A2');

        return $drawing;
    }
}
