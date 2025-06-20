<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\requestPendaftaran;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PDF;

class LaporanExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $query = requestPendaftaran::query();

        // Apply filters
        if ($request->status_izin && $request->status_izin !== 'semua') {
            $query->where('proses_terakhir', $request->status_izin);
        }

        if ($request->jenis_permohonan && $request->jenis_permohonan !== 'semua') {
            $query->where('jenis_permohonan', $request->jenis_permohonan);
        }

        if ($request->jenis_izin) {
            $query->where('jenis_izin', $request->jenis_izin);
        }

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $data = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Pemohon');
        $sheet->setCellValue('C1', 'Jenis Izin');
        $sheet->setCellValue('D1', 'Jenis Permohonan');
        $sheet->setCellValue('E1', 'Tanggal Pengajuan');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Nomor Izin');

        // Add data
        $row = 2;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->nama_pemohon);
            $sheet->setCellValue('C' . $row, $item->jenis_izin);
            $sheet->setCellValue('D' . $row, $item->jenis_permohonan);
            $sheet->setCellValue('E' . $row, $item->created_at->format('d/m/Y'));
            $sheet->setCellValue('F' . $row, $item->proses_terakhir);
            $sheet->setCellValue('G' . $row, $item->nomor_izin ?? '-');
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan_perizinan_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function exportPDF(Request $request)
    {
        $query = requestPendaftaran::query();

        // Apply filters
        if ($request->status_izin && $request->status_izin !== 'semua') {
            $query->where('proses_terakhir', $request->status_izin);
        }

        if ($request->jenis_permohonan && $request->jenis_permohonan !== 'semua') {
            $query->where('jenis_permohonan', $request->jenis_permohonan);
        }

        if ($request->jenis_izin) {
            $query->where('jenis_izin', $request->jenis_izin);
        }

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $data = $query->get();

        $pdf = PDF::loadView('laporan.export-pdf', [
            'data' => $data,
            'filters' => $request->all()
        ]);

        $filename = 'laporan_perizinan_' . date('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
} 