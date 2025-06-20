<?php

namespace App\Exports;

use App\Models\RekapitulasiIzin;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapitulasiIzinExport
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Resi');
        $sheet->setCellValue('C1', 'Pemohon');
        $sheet->setCellValue('D1', 'Perusahaan');
        $sheet->setCellValue('E1', 'Jenis Proses Perizinan');
        $sheet->setCellValue('F1', 'Status');

        // Populate the data
        $rowNumber = 2;
        foreach ($this->data as $index => $item) {
            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValue('B' . $rowNumber, $item->resi);
            $sheet->setCellValue('C' . $rowNumber, $item->pemohon);
            $sheet->setCellValue('D' . $rowNumber, $item->perusahaan);
            $sheet->setCellValue('E' . $rowNumber, $item->jenis_proses_perizinan);
            $sheet->setCellValue('F' . $rowNumber, $item->status);
            $rowNumber++;
        }

        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('exports/rekapitulasi_izin.xlsx');
        $writer->save($filePath);

        return response()->download($filePath);
    }
}

