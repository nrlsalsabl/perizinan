<?php

namespace App\Helpers;

use App\Models\DaftarPerizinan;
use Carbon\Carbon;

class PermitNumberGenerator
{
    public static function generate($jenisIzinId)
    {
        // Get the jenis izin name
        $jenisIzin = \App\Models\JenisIzin::findOrFail($jenisIzinId);
        
        // Get the permit format from DaftarPerizinan
        $daftarPerizinan = DaftarPerizinan::where('nama_jenis_perizinan', $jenisIzin->nama_jenis_izin)->first();

        if (!$daftarPerizinan || !$daftarPerizinan->format_no_izin) {
            throw new \Exception('Format nomor izin tidak ditemukan');
        }

        $format = $daftarPerizinan->format_no_izin;
        
        // Get current year and month
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        
        // Get the last permit number for this type
        $lastPermit = \App\Models\IzinTerbit::where('jenis_izin_id', $jenisIzinId)
            ->orderBy('id', 'desc')
            ->first();
            
        // Generate sequence number
        $sequence = 1;
        if ($lastPermit) {
            // Extract sequence from last permit number
            $lastNumber = $lastPermit->no_izin;
            $lastSequence = (int) substr($lastNumber, -4);
            $sequence = $lastSequence + 1;
        }
        
        // Replace format placeholders
        $number = str_replace(
            ['{YEAR}', '{MONTH}', '{SEQ}'],
            [$year, $month, str_pad($sequence, 4, '0', STR_PAD_LEFT)],
            $format
        );
        
        return $number;
    }
} 