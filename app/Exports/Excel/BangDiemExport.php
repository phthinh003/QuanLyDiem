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
    protected $loaimon;

    public function __construct($data, $loaimon)
    {
        $this->data = $data;
        $this->loaimon = $loaimon;
    }

    // Dữ liệu bảng điểm
    public function array(): array
    {
        return $this->data;
    }

    // Header nhiều dòng: dòng 1 là nhóm tiêu đề, dòng 2 là chi tiết
    public function headings(): array
    {
        $dataloaidiem = LoaiDiem::all()->whereIn('loaimon', [0, 3])->sortBy('heso');
        // dd($dataloaidiem);
        // Row 1
        $arrRow1 = ['STT', 'Họ và tên'];
        $arrRow2 = ['', ''];
        foreach ($dataloaidiem as $key => $value) {
            $arrRow1[] = $value->tenloaidiem;
            $arrRow2[] = $value->soluong > 1 ?'L1' : '';
            // $arrRow2[] = 'L1';
            for ($i = 2; $i <= $value->soluong; $i++) {
                $arrRow1[] = '';
                $arrRow2[] = $value->soluong > 1 ? 'L' . $i : '';
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

                $dataloaidiem = LoaiDiem::all()->whereIn('loaimon', [$this->loaimon, 3])->sortBy('heso');

                // Merge dòng 1
                $sheet->mergeCells('A1:A2'); // STT
                $sheet->mergeCells('B1:B2'); // Họ Tên

                // Xử lý merge ô điểm header
                $index = 2;
                foreach ($dataloaidiem as $key => $loaidiem) {
                    $column_name_start = $this->getExcelColumnName($index);
                    $column_name_end = $this->getExcelColumnName($index + $loaidiem->soluong - 1);
                    $sheet->mergeCells($column_name_start . '1:' . $column_name_end . '1');

                    // Điểm có số lượng 1
                    if ($loaidiem->soluong == 1) {
                        $sheet->mergeCells($column_name_start . '1:' . $column_name_start . '2');
                    }

                    $index += $loaidiem->soluong;
                    // dd($column_name_start, $column_name_end, $index);
                }

                // $sheet->mergeCells('C1:F1'); // KT thường xuyên
                // $sheet->mergeCells('G1:H1'); // KT 1 tiết
                // $sheet->mergeCells('I1:I2'); // Cuối kỳ
                // $sheet->mergeCells('J1:J2');

                $sheet->mergeCells($this->getExcelColumnName($index) . '1:' . $this->getExcelColumnName($index) . '2'); // TBM

                // Căn giữa
                $sheet->getStyle('A1:' . $this->getExcelColumnName($index) . '2')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'font' => ['bold' => true],
                ]);

                // Thêm border toàn bảng
                $highestRow = $sheet->getHighestRow(); // Hàng lớn nhất
                $highestColumn = $sheet->getHighestColumn(); // Cột lớn nhất
                $dataRange = 'A1:' . $highestColumn . $highestRow;

                // Áp dụng border cho toàn bộ vùng có dữ liệu
                $sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Căn giữa số thứ tự
                $dataRange = 'A1:' . 'A' . $highestRow;
                $sheet->getStyle($dataRange)->applyFromArray([
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
    function getExcelColumnName($index)
    {
        $name = '';
        while ($index >= 0) {
            $name = chr($index % 26 + 65) . $name;
            $index = intval($index / 26) - 1;
        }
        return $name;
    }
}
