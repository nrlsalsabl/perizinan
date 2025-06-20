<?php

namespace App\Http\Controllers;

use App\Models\requestPendaftaran;
use Illuminate\Http\Request;

class VerificationStatusController extends Controller
{
    public function getStatus($pengajuanId)
    {
        // Get the latest verification record for Kasi
        $kasiStatus = requestPendaftaran::where('pengajuan_id', $pengajuanId)
            ->where('role', 'Kasi')
            ->latest()
            ->first();

        // Get the latest verification record for Back Office
        $backOfficeStatus = requestPendaftaran::where('pengajuan_id', $pengajuanId)
            ->where('role', 'Back Office')
            ->latest()
            ->first();

        // Helper function to determine status
        $getStatus = function($record) {
            if (!$record) return 'Menunggu Verifikasi';
            if ($record->proses_terakhir === 'Ditolak') return 'Ditolak';
            if ($record->verification_status === 'verified') return 'Terverifikasi';
            return 'Menunggu Verifikasi';
        };

        return response()->json([
            'kasi' => $getStatus($kasiStatus),
            'backoffice' => $getStatus($backOfficeStatus)
        ]);
    }
} 