<?php
namespace App\Exports\Excel;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

// Models
use App\Models\LoaiDiem;

class BangDiemExport implements FromArray, WithHeadings, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    // Dữ liệu bảng điểm
    public function array(): array
    {
        return $this->data;
    }

    // Header nhiều dòng: dòng 1 là nhóm tiêu đề, dòng 2 là chi tiết
    public function headings(): array
    {
        $data = LoaiDiem::all()->whereIn('loaimon', [1,3])->sortBy('heso');
        // Row 1
        $arrRow1 = ['STT', 'Họ và tên'];
        $arrRow2 = ['', ''];
        foreach ($data as $key => $value) {
            $arrRow1[] = $value->tenloaidiem;
            $arrRow2[] = $value->soluong > 1 ?'L1' : '';
            for ($i=0; $i<$value->soluong-1; $i++) {
                $arrRow1[] = '';
                $arrRow2[] = $value->soluong > 1 ?'L'.$i+2 : '';
            }
        }

        $arrRow1[] = "TBM";
        $arrRow2[] = '';
        return [
            $arrRow1,
            $arrRow2,
        ];
    }

    // Merge và style nhóm cột
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Merge dòng 1
                $sheet->mergeCells('A1:A2'); // STT
                $sheet->mergeCells('B1:B2'); // Họ Tên
                $sheet->mergeCells('C1:F1'); // KT thường xuyên
                $sheet->mergeCells('G1:H1'); // KT 1 tiết
                $sheet->mergeCells('I1:I2'); // Cuối kỳ
                $sheet->mergeCells('J1:J2'); // TBM

                // Căn giữa
                $sheet->getStyle('A1:J2')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => ['bold' => true],
                ]);
            },
        ];
    }

    // Column excel
    function getExcelColumnName($index) {
        $name = '';
        while ($index >= 0) {
            $name = chr($index % 26 + 65) . $name;
            $index = intval($index / 26) - 1;
        }
        return $name;
    }
}
