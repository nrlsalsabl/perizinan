<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kecamatan;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        $kecamatans = [
            // Kabupaten Paser
            ['kode' => '6401010', 'nama' => 'PASER BELENGKONG', 'kabupaten_kota' => '6401'],
            ['kode' => '6401020', 'nama' => 'TANAH GROGOT', 'kabupaten_kota' => '6401'],
            ['kode' => '6401030', 'nama' => 'KUARO', 'kabupaten_kota' => '6401'],
            ['kode' => '6401040', 'nama' => 'LONG IKIS', 'kabupaten_kota' => '6401'],
            ['kode' => '6401050', 'nama' => 'MUARA KOMAM', 'kabupaten_kota' => '6401'],
            ['kode' => '6401060', 'nama' => 'LONG KALI', 'kabupaten_kota' => '6401'],
            ['kode' => '6401070', 'nama' => 'BATU ENGAU', 'kabupaten_kota' => '6401'],
            ['kode' => '6401080', 'nama' => 'MUARA SAMU', 'kabupaten_kota' => '6401'],

            // Kabupaten Kutai Barat
            ['kode' => '6402010', 'nama' => 'MUARA PAHU', 'kabupaten_kota' => '6402'],
            ['kode' => '6402020', 'nama' => 'LONG IRAM', 'kabupaten_kota' => '6402'],
            ['kode' => '6402030', 'nama' => 'MELAK', 'kabupaten_kota' => '6402'],
            ['kode' => '6402040', 'nama' => 'NUHUN', 'kabupaten_kota' => '6402'],
            ['kode' => '6402050', 'nama' => 'BENTIAN BESAR', 'kabupaten_kota' => '6402'],
            ['kode' => '6402060', 'nama' => 'DAMAI', 'kabupaten_kota' => '6402'],
            ['kode' => '6402070', 'nama' => 'NYUATAN', 'kabupaten_kota' => '6402'],
            ['kode' => '6402080', 'nama' => 'BARONG TONGKOK', 'kabupaten_kota' => '6402'],
            ['kode' => '6402090', 'nama' => 'LINGGANG BIGUNG', 'kabupaten_kota' => '6402'],
            ['kode' => '6402100', 'nama' => 'JEMPANG', 'kabupaten_kota' => '6402'],
            ['kode' => '6402110', 'nama' => 'PENYINGGAHAN', 'kabupaten_kota' => '6402'],
            ['kode' => '6402120', 'nama' => 'BATU BOLA', 'kabupaten_kota' => '6402'],
            ['kode' => '6402130', 'nama' => 'MUARA LAWA', 'kabupaten_kota' => '6402'],
            ['kode' => '6402140', 'nama' => 'MUARA PAHU', 'kabupaten_kota' => '6402'],
            ['kode' => '6402150', 'nama' => 'LONG HUBUNG', 'kabupaten_kota' => '6402'],
            ['kode' => '6402160', 'nama' => 'LAHAM', 'kabupaten_kota' => '6402'],
            ['kode' => '6402170', 'nama' => 'LONG BAGUN', 'kabupaten_kota' => '6402'],
            ['kode' => '6402180', 'nama' => 'LONG PAHANGAI', 'kabupaten_kota' => '6402'],
            ['kode' => '6402190', 'nama' => 'LONG APARI', 'kabupaten_kota' => '6402'],

            // Kabupaten Kutai Kartanegara
            ['kode' => '6403010', 'nama' => 'LOA JANAN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403020', 'nama' => 'LOA KULU', 'kabupaten_kota' => '6403'],
            ['kode' => '6403030', 'nama' => 'MUARA MUNTAI', 'kabupaten_kota' => '6403'],
            ['kode' => '6403040', 'nama' => 'MUARA WIS', 'kabupaten_kota' => '6403'],
            ['kode' => '6403050', 'nama' => 'KOTABANGUN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403060', 'nama' => 'KENOHAN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403070', 'nama' => 'TABANG', 'kabupaten_kota' => '6403'],
            ['kode' => '6403080', 'nama' => 'MUARA BENGKAL', 'kabupaten_kota' => '6403'],
            ['kode' => '6403090', 'nama' => 'BENGALON', 'kabupaten_kota' => '6403'],
            ['kode' => '6403100', 'nama' => 'BUSANG', 'kabupaten_kota' => '6403'],
            ['kode' => '6403110', 'nama' => 'LONG MESANGAT', 'kabupaten_kota' => '6403'],
            ['kode' => '6403120', 'nama' => 'MUARA ANCALONG', 'kabupaten_kota' => '6403'],
            ['kode' => '6403130', 'nama' => 'MUARA WAHAU', 'kabupaten_kota' => '6403'],
            ['kode' => '6403140', 'nama' => 'TELEN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403150', 'nama' => 'KONGBENG', 'kabupaten_kota' => '6403'],
            ['kode' => '6403160', 'nama' => 'MUARA BENGKAL', 'kabupaten_kota' => '6403'],
            ['kode' => '6403170', 'nama' => 'BATU AMPAR', 'kabupaten_kota' => '6403'],
            ['kode' => '6403180', 'nama' => 'SANGATTA UTARA', 'kabupaten_kota' => '6403'],
            ['kode' => '6403190', 'nama' => 'BENGALON', 'kabupaten_kota' => '6403'],
            ['kode' => '6403200', 'nama' => 'TELUK PANDAN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403210', 'nama' => 'SANGATTA SELATAN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403220', 'nama' => 'RANTAU PULUNG', 'kabupaten_kota' => '6403'],
            ['kode' => '6403230', 'nama' => 'SANGKULIRANG', 'kabupaten_kota' => '6403'],
            ['kode' => '6403240', 'nama' => 'KALIORANG', 'kabupaten_kota' => '6403'],
            ['kode' => '6403250', 'nama' => 'SANDARAN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403260', 'nama' => 'KAUBUN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403270', 'nama' => 'KARANGAN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403280', 'nama' => 'KELAY', 'kabupaten_kota' => '6403'],
            ['kode' => '6403290', 'nama' => 'TALISAYAN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403300', 'nama' => 'TABALAR', 'kabupaten_kota' => '6403'],
            ['kode' => '6403310', 'nama' => 'BIDUK BIDUK', 'kabupaten_kota' => '6403'],
            ['kode' => '6403320', 'nama' => 'PULAU DERAWAN', 'kabupaten_kota' => '6403'],
            ['kode' => '6403330', 'nama' => 'MARATUA', 'kabupaten_kota' => '6403'],
            ['kode' => '6403340', 'nama' => 'SAMBALIUNG', 'kabupaten_kota' => '6403'],
            ['kode' => '6403350', 'nama' => 'TANJUNG REDEB', 'kabupaten_kota' => '6403'],
            ['kode' => '6403360', 'nama' => 'GUNUNG TABUR', 'kabupaten_kota' => '6403'],
            ['kode' => '6403370', 'nama' => 'SEGAH', 'kabupaten_kota' => '6403'],
            ['kode' => '6403380', 'nama' => 'TELUK BAYUR', 'kabupaten_kota' => '6403'],
            ['kode' => '6403390', 'nama' => 'BATU PUTIH', 'kabupaten_kota' => '6403'],
            ['kode' => '6403400', 'nama' => 'BIATAN', 'kabupaten_kota' => '6403'],

            // Kota Balikpapan
            ['kode' => '6471010', 'nama' => 'BALIKPAPAN SELATAN', 'kabupaten_kota' => '6471'],
            ['kode' => '6471020', 'nama' => 'BALIKPAPAN KOTA', 'kabupaten_kota' => '6471'],
            ['kode' => '6471030', 'nama' => 'BALIKPAPAN TIMUR', 'kabupaten_kota' => '6471'],
            ['kode' => '6471040', 'nama' => 'BALIKPAPAN UTARA', 'kabupaten_kota' => '6471'],
            ['kode' => '6471050', 'nama' => 'BALIKPAPAN TENGAH', 'kabupaten_kota' => '6471'],
            ['kode' => '6471060', 'nama' => 'BALIKPAPAN BARAT', 'kabupaten_kota' => '6471'],

            // Kota Samarinda
            ['kode' => '6472010', 'nama' => 'PALARAN', 'kabupaten_kota' => '6472'],
            ['kode' => '6472020', 'nama' => 'SAMARINDA ILIR', 'kabupaten_kota' => '6472'],
            ['kode' => '6472030', 'nama' => 'SAMARINDA KOTA', 'kabupaten_kota' => '6472'],
            ['kode' => '6472040', 'nama' => 'SAMBUTAN', 'kabupaten_kota' => '6472'],
            ['kode' => '6472050', 'nama' => 'SAMARINDA SEBERANG', 'kabupaten_kota' => '6472'],
            ['kode' => '6472060', 'nama' => 'LOA JANAN ILIR', 'kabupaten_kota' => '6472'],
            ['kode' => '6472070', 'nama' => 'SUNGAI KUNJANG', 'kabupaten_kota' => '6472'],
            ['kode' => '6472080', 'nama' => 'SAMARINDA ULU', 'kabupaten_kota' => '6472'],
            ['kode' => '6472090', 'nama' => 'SAMARINDA UTARA', 'kabupaten_kota' => '6472'],
            ['kode' => '6472100', 'nama' => 'SUNGAI PINANG', 'kabupaten_kota' => '6472'],

            // Kota Bontang
            ['kode' => '6474010', 'nama' => 'BONTANG SELATAN', 'kabupaten_kota' => '6474'],
            ['kode' => '6474020', 'nama' => 'BONTANG UTARA', 'kabupaten_kota' => '6474'],
            ['kode' => '6474030', 'nama' => 'BONTANG BARAT', 'kabupaten_kota' => '6474']
        ];

        foreach ($kecamatans as $kecamatan) {
            DB::table('kecamatans')->updateOrInsert(
                ['kode' => $kecamatan['kode']],
                $kecamatan
            );
        }
    }
} 