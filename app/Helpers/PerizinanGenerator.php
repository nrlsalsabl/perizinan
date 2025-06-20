<?php

namespace App\Helpers;

use App\Models\DaftarPerizinan;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PerizinanGenerator
{
    public static function generateKode($namaJenisPerizinan)
    {
        // Get first letter of each word and convert to uppercase
        $words = explode(' ', $namaJenisPerizinan);
        $kode = '';
        foreach ($words as $word) {
            $kode .= strtoupper(substr($word, 0, 1));
        }
        
        // Add timestamp to make it unique
        $kode .= date('Ymd');
        
        return $kode;
    }

    public static function generateFormatNoIzin($namaJenisPerizinan)
    {
        // Get first letter of each word and convert to uppercase
        $words = explode(' ', $namaJenisPerizinan);
        $prefix = '';
        foreach ($words as $word) {
            $prefix .= strtoupper(substr($word, 0, 1));
        }
        
        // Create format with prefix
        return $prefix . '/{YEAR}/{MONTH}/{SEQ}';
    }

    public static function generateMasaBerlaku($jenisPerizinan)
    {
        // Default masa berlaku based on jenis perizinan
        $masaBerlaku = [
            'izin usaha' => 5,
            'izin operasional' => 3,
            'izin lingkungan' => 4,
            'izin bangunan' => 2,
            'izin lokasi' => 3,
            'izin mendirikan bangunan' => 2,
            'izin gangguan' => 3,
            'izin usaha perdagangan' => 5,
            'izin usaha industri' => 5,
            'izin usaha mikro kecil' => 5,
        ];

        // Convert to lowercase for matching
        $jenis = strtolower($jenisPerizinan);
        
        // Find matching masa berlaku or return default
        foreach ($masaBerlaku as $key => $value) {
            if (strpos($jenis, $key) !== false) {
                return $value;
            }
        }
        
        return 5; // Default 5 tahun if no match found
    }

    public static function generateSOP($jenisPerizinan)
    {
        // Default SOP days based on jenis perizinan
        $sopDays = [
            'izin usaha' => 5,
            'izin operasional' => 7,
            'izin lingkungan' => 10,
            'izin bangunan' => 14,
            'izin lokasi' => 7,
            'izin mendirikan bangunan' => 14,
            'izin gangguan' => 5,
            'izin usaha perdagangan' => 5,
            'izin usaha industri' => 7,
            'izin usaha mikro kecil' => 5,
        ];

        // Convert to lowercase for matching
        $jenis = strtolower($jenisPerizinan);
        
        // Find matching SOP days or return default
        foreach ($sopDays as $key => $value) {
            if (strpos($jenis, $key) !== false) {
                return $value;
            }
        }
        
        return 7; // Default 7 days if no match found
    }

    public static function generateDinasBadan($jenisPerizinan)
    {
        // Default dinas/badan based on jenis perizinan
        $dinasMapping = [
            'izin usaha' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
            'izin operasional' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
            'izin lingkungan' => 'Dinas Lingkungan Hidup',
            'izin bangunan' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
            'izin lokasi' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
            'izin mendirikan bangunan' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
            'izin gangguan' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
            'izin usaha perdagangan' => 'Dinas Perdagangan',
            'izin usaha industri' => 'Dinas Perindustrian',
            'izin usaha mikro kecil' => 'Dinas Koperasi dan Usaha Mikro Kecil Menengah',
        ];

        // Convert to lowercase for matching
        $jenis = strtolower($jenisPerizinan);
        
        // Find matching dinas/badan or return default
        foreach ($dinasMapping as $key => $value) {
            if (strpos($jenis, $key) !== false) {
                return $value;
            }
        }
        
        return 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu'; // Default dinas
    }
} 