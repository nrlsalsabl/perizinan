<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RenameDuplicateJenisIzins extends Migration
{
    public function up()
    {
        // Predefined unique names for jenis izin
        $uniqueNames = [
            'IZIN ANGKUTAN DALAM TRAYEK/ANGKUTAN ANTAR KOTA DALAM PROVINSI',
            'IZIN MENDIRIKAN BANGUNAN',
            'Izin Usaha',
            'Izin Usaha Lain 1',
            'Izin Usaha Lain 2',
            'Izin Usaha Lain 3',
            'Izin Usaha Lain 4',
            'Izin Usaha Lain 5',
            'Izin Usaha Lain 6',
            'Izin Usaha Lain 7'
        ];

        // Fetch all entries
        $jenisIzins = DB::table('jenis_izins')->get();

        // Store seen names and used unique names
        $seenNames = [];
        $usedUniqueNames = [];

        foreach ($jenisIzins as $jenisIzin) {
            $name = $jenisIzin->nama_jenis_izin;

            // Check if name is a duplicate
            if (isset($seenNames[$name])) {
                $newName = null;

                // Find a unique name that hasn't been used
                foreach ($uniqueNames as $uniqueName) {
                    if (!in_array($uniqueName, $usedUniqueNames)) {
                        $newName = $uniqueName;
                        $usedUniqueNames[] = $newName;
                        break;
                    }
                }

                // Update the name in the database if a new name was found
                if ($newName) {
                    DB::table('jenis_izins')
                        ->where('id', $jenisIzin->id)
                        ->update(['nama_jenis_izin' => $newName]);

                    $seenNames[$newName] = 1;
                }
            } else {
                $seenNames[$name] = 1;
                $usedUniqueNames[] = $name;
            }
        }
    }

    public function down()
    {
        // Logic to revert changes, if needed
    }
}
