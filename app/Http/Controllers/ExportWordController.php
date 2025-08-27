<?php

namespace App\Http\Controllers;

use App\Models\Diem;
use App\Models\HocSinh;
use App\Models\Lop;
use App\Models\Mon;
use App\Models\MonHoc;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

class ExportWordController extends Controller
{

    public function xuatPhieuDiemTatCa($malop, $hk)
    {
        $lop = Lop::join('nienkhoa', 'nienkhoa.manienkhoa', 'lop.nienkhoa')
            ->select('lop.malop', 'tennienkhoa', 'tenlop')
            ->find($malop);
        // dd($lop);
        $danhSachHocSinh = HocSinh::join('lophoc', 'lophoc.mahocsinh', 'hocsinh.mahocsinh')
            ->where('malop', $malop)
            ->select('hocsinh.mahocsinh', 'hotenhocsinh')
            ->get();
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(13);

        foreach ($danhSachHocSinh as $hs) {
            $section = $phpWord->addSection([
                'orientation' => 'landscape', // khổ giấy ngang
                'marginTop' => 1000,
                'marginBottom' => 1000,
                'marginLeft' => 1000,
                'marginRight' => 1000
            ]);

            // ===== Phần tiêu đề 2 cột (Bộ + Quốc hiệu) =====
            $tableHeader = $section->addTable([
                'alignment' => Jc::CENTER,
                'width' => 20000, // 100%
            ]);

            $tableHeader->addRow();
            $cellLeft = $tableHeader->addCell(10000);
            $cellLeft->addText("SỞ GIÁO DỤC VÀ ĐÀO TẠO", ['bold' => true, 'allCaps' => true], ['align' => 'center']);
            $cellLeft->addText("TRƯỜNG TRUNG HỌC PHỔ THÔNG TÂY ĐÔ", ['bold' => true, 'allCaps' => true], ['align' => 'center']);

            $cellRight = $tableHeader->addCell(10000);
            $cellRight->addText("CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM", ['bold' => true, 'allCaps' => true], ['align' => 'center']);
            $cellRight->addText("Độc lập - Tự do - Hạnh phúc", ['italic' => false], ['align' => 'center']);
            $cellRight->addText("────────────", [], ['align' => 'center']); // gạch ngang

            $section->addTextBreak(1);

            // Tiêu đề phiếu điểm
            $section->addText(
                'PHIẾU ĐIỂM HỌC SINH',
                ['bold' => true, 'size' => 16, 'underline' => 'single'],
                ['align' => 'center']
            );
            $section->addTextBreak(1);

            // Thông tin học sinh
            // dd($lop);
            $section->addText("Họ và tên: {$hs->hotenhocsinh}");
            $section->addText("Lớp: {$lop->tenlop}");
            $section->addText($lop->tennienkhoa);
            if ($hk < 3) $section->addText("Học kì:{$hk}");
            $section->addTextBreak(1);
            // Dữ liệu điểm
            if ($hk < 3) {
                // Tạo bảng điểm ngang
                $table = $section->addTable([
                    'borderSize' => 6,
                    'borderColor' => '000000',
                    'cellMargin' => 80,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
                ]);
                // Lấy danh sách môn học của học sinh
                $monHocList = MonHoc::join('mon','mon.mamon','monhoc.mamon')
                            ->where('malop',$malop)->get();

                // ===== Hàng 1: Tiêu đề cột (Môn học) =====
                $table->addRow();
                $table->addCell(3000, ['bgColor' => 'cccccc'])->addText('Môn học', ['bold' => true]);
                $diemtb = [];
                foreach ($monHocList as $mon) {
                    // dd($mon);
                    $diemtb[] = Diem::tbm($hs->mahocsinh, $mon->mamonhoc, $hk);

                    $table->addCell(1500, ['bgColor' => 'cccccc'])->addText($mon->tenmon, ['bold' => true]);
                }
                // ===== Hàng 2: Điểm TB =====

                $tot = 0;
                $kha = 0;
                $i = 0;

                $nottot = false;
                $notkha = false;
                $notdat = false;
                $diem = 0;
                $table->addRow();
                $table->addCell(3000)->addText('Điểm TB', ['bold' => true]);
                foreach ($diemtb as $dtb) {
                    if ($dtb != '') {
                        if(is_numeric($dtb)) {
                            $diem += $dtb;

                            // so luong diem
                            if ($dtb >= 8) $tot++;
                            if ($dtb >= 6.5) $kha++;

                            // diem liet
                            if ($dtb < 6.5) $nottot = true;
                            if ($dtb < 5) $notkha = true;
                            if ($dtb < 3.5) $notdat = true;
                            // ghi diem vao word
                            $table->addCell(1500)->addText(number_format($dtb, 1));
                        }else{
                            if ($dtb === "Chưa đạt") {
                                $i++;
                                $nottot = true;
                                $notkha = true;
                            }
                            if ($i > 1) {
                                $notdat = true;
                            }
                            $table->addCell(1500)->addText($dtb);
                        }
                    } else
                        // ghi diem vao word
                        $table->addCell(1500)->addText("");
                }
                $table->addRow(10, [
                    'bordercolor' => 'ffffff',
                ]);
                $table->addCell(1500, ['bordersize' => 0, 'borderColor' => 'ffffff']);
                $table->addRow();
                $table->addCell(1500, ['bgColor' => 'cccccc'])->addText('Trung bình học kì', ['bold' => true]);
                $table->addCell(1500)->addText(number_format($diem / count($diemtb), 1), ['bold' => true]);

                if ($notdat == true) $xeploai = "Chưa đạt";
                else {
                    $xeploai = "Đạt";
                    if ($nottot == false && $tot >= 6) $xeploai = "Tốt";
                    else if ($notkha == false && $kha >= 6) $xeploai = "Khá";
                }
                $table->addRow();
                $table->addCell(1500, ['bgColor' => 'cccccc'])->addText('Xếp loại', ['bold' => true]);
                $table->addCell(1500)->addText($xeploai, ['bold' => true]);

                $section->addTextBreak(1);
                $section->addText("Nhận xét: ", ['italic' => true]);
                $section->addTextBreak(2);
            } else {
                // Tạo bảng điểm ngang
                $table = $section->addTable([
                    'borderSize' => 6,
                    'borderColor' => '000000',
                    'cellMargin' => 80,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
                ]);
                // Lấy danh sách môn học của học sinh
                $monHocList = MonHoc::join('mon','mon.mamon','monhoc.mamon')
                            ->where('malop',$malop)->get();

                // ===== Hàng 1: Tiêu đề cột (Môn học) =====
                $table->addRow();
                $table->addCell(3000, ['bgColor' => 'cccccc'])->addText('Môn học', ['bold' => true]);
                $diemtb = [];
                $sldiem=0;
                $tb=0;
                foreach ($monHocList as $mon) {
                    // dd($mon);
                    $diemtb1 = Diem::tbm($hs->mahocsinh, $mon->mamonhoc, 1);
                    $diemtb2 = Diem::tbm($hs->mahocsinh, $mon->mamonhoc, 2);
                    if ($diemtb1 == "" || $diemtb2 == "") {
                        $diemtb[] = "";
                    } else {
                        if ($mon->kieudiem == 0) {
                            $diemtb[] = ((float)$diemtb1 + (float)$diemtb2 * 2) / 3;
                            $sldiem++;
                            $tb += ((float)$diemtb1 + (float)$diemtb2 * 2) / 3;
                        } else {
                            $diemtb[] = $diemtb2;
                        }
                    }

                    $table->addCell(1500, ['bgColor' => 'cccccc'])->addText($mon->tenmon, ['bold' => true]);
                }

                // dd($sldiem,$tb);
                // ===== Hàng 2: Điểm TB =====

                $tot = 0;
                $kha = 0;
                $i=0;

                $nottot = false;
                $notkha = false;
                $notdat = false;
                $table->addRow();
                $table->addCell(3000)->addText('Điểm TB', ['bold' => true]);
                foreach ($diemtb as $dtb) {
                    if ($dtb != '') {
                        if ($dtb == "Đạt" || $dtb == "Chưa đạt") {
                            if ($dtb == "Chưa đạt") {
                                $i++;
                                $nottot = true;
                                $notkha = true;
                            }
                            if ($i > 1) {
                                $notdat = true;
                            }
                            $table->addCell(1500)->addText($dtb);
                        } else {
                            // so luong diem
                            if ($dtb >= 8) $tot++;
                            if ($dtb >= 6.5) $kha++;

                            // diem liet
                            if ($dtb < 6.5) $nottot = true;
                            if ($dtb < 5) $notkha = true;
                            if ($dtb < 3.5) $notdat = true;
                            // ghi diem vao word
                            $table->addCell(1500)->addText(number_format($dtb, 1));
                        }
                    } else
                        // ghi diem vao word
                        $table->addCell(1500)->addText("");
                }
                $table->addRow(10, [
                    'bordercolor' => 'ffffff',
                ]);
                $table->addCell(1500, ['bordersize' => 0, 'borderColor' => 'ffffff']);
                $table->addRow();
                $table->addCell(1500, ['bgColor' => 'cccccc'])->addText('Trung bình cả năm', ['bold' => true]);
                $table->addCell(1500)->addText(number_format($tb / $sldiem, 1), ['bold' => true]);

                if ($notdat == true) $xeploai = "Chưa đạt";
                else {
                    $xeploai = "Đạt";
                    if ($nottot == false && $tot >= 6) $xeploai = "Tốt";
                    else if ($notkha == false && $kha >= 6) $xeploai = "Khá";
                }
                $table->addRow();
                $table->addCell(1500, ['bgColor' => 'cccccc'])->addText('Xếp loại', ['bold' => true]);
                $table->addCell(1500)->addText($xeploai, ['bold' => true]);

                $section->addTextBreak(1);
                $section->addText("Nhận xét: ", ['italic' => true]);
                $section->addTextBreak(2);
            }

            // Ký tên
            $section->addText(
                'Giáo viên chủ nhiệm',
                ['bold' => true],
                ['align' => 'right']
            );
        }

        // Lưu file
        $fileName = 'Phieu_Diem_' . $lop->tenlop . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $phpWord->save($filePath, 'Word2007');

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
