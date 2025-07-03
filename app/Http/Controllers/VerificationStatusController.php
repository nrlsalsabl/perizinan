<?php

namespace App\Http\Controllers;

use App\Models\requestPendaftaran;
use Illuminate\Http\Request;

class VerificationStatusController extends Controller
{
    
    public function getStatus($pengajuanId)
{
    $frontOfficeStatus = requestPendaftaran::where('pengajuan_id', $pengajuanId)
        ->where('role', 'Front Office')
        ->latest()
        ->first();

    $kasiStatus = requestPendaftaran::where('pengajuan_id', $pengajuanId)
        ->where('role', 'Kasi')
        ->latest()
        ->first();

    $backOfficeStatus = requestPendaftaran::where('pengajuan_id', $pengajuanId)
        ->where('role', 'Back Office')
        ->latest()
        ->first();

    $getStatus = function($record) {
        if (!$record) return 'Menunggu Verifikasi';
        if ($record->proses_terakhir === 'Ditolak') return 'Ditolak';
        if ($record->verification_status === 'verified') return 'Terverifikasi';
        return 'Menunggu Verifikasi';
    };

    return response()->json([
        'frontoffice' => $getStatus($frontOfficeStatus),
        'kasi' => $getStatus($kasiStatus),
        'backoffice' => $getStatus($backOfficeStatus)
    ]);
}

}