<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunLevel3Seeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [1, 0, 0, 1, '1.1.01.00', 'Kas', 1, 'debet'],
            [1, 0, 0, 2, '1.1.02.00', 'Kas Setara Kas', 1, 'debet'],
            [1, 0, 0, 3, '1.1.03.00', 'Piutang', 1, 'debet'],
            [1, 0, 0, 4, '1.1.04.00', 'Cadangan Kerugian Piutang', 1, 'debet'],
            [1, 0, 0, 5, '1.1.05.00', 'Persediaan', 1, 'debet'],
            [1, 0, 0, 6, '1.1.06.00', 'Rekening Antar Kantor', 1, 'debet'],
            [2, 0, 0, 2, '1.2.01.00', 'Aktiva Tetap dan Inventaris', 1, 'debet'],
            [2, 0, 0, 2, '1.2.02.00', 'Akumulasi Penyusutan Aktiva Tetap dan Inventaris', 1, 'debet'],
            [2, 0, 0, 3, '1.2.03.00', 'Aset Tak Berwujud', 1, 'debet'],
            [2, 0, 0, 4, '1.2.04.00', 'Akumulasi Amortisasi Aset Tak Berwujud', 1, 'debet'],
            [2, 0, 0, 5, '1.2.05.00', 'Konstruksi Dalam Pengerjaan', 1, 'debet'],
            [3, 0, 0, 3, '1.3.01.00', 'Aset Lain-lain', 1, 'debet'],
            [4, 0, 0, 1, '2.1.01.00', 'Utang Dividen', 1, 'kredit'],
            [4, 0, 0, 1, '2.1.02.00', 'Utang Biaya Operasional', 1, 'kredit'],
            [4, 0, 0, 1, '2.1.03.00', 'Utang Pajak', 1, 'kredit'],
            [4, 0, 0, 1, '2.1.04.00', 'Simpanan Jangka Pendek', 1, 'kredit'],
            [4, 0, 0, 1, '2.1.05.00', 'Utang Jangka Pendek Lainnya', 1, 'kredit'],
            [5, 0, 0, 2, '2.2.01.00', 'Utang Jangka Panjang Lainnya', 1, 'kredit'],
            [5, 0, 0, 2, '2.2.02.00', 'Simpanan Jangka Panjang', 1, 'kredit'],
            [6, 0, 0, 1, '3.1.01.00', 'Modal Disetor', 1, 'kredit'],
            [6, 0, 0, 1, '3.1.02.00', 'Modal Lain-lain', 1, 'kredit'],
            [7, 0, 0, 2, '3.2.01.00', 'Laba Ditahan', 1, 'kredit'],
            [7, 0, 0, 2, '3.2.02.00', 'Laba Rugi Berjalan', 1, 'kredit'],
            [8, 0, 0, 1, '4.1.01.00', 'Pendapatan Usaha Utama', 1, 'kredit'],
            [8, 0, 0, 1, '4.1.02.00', 'Pendapatan Usaha Lain', 1, 'kredit'],
            [8, 0, 0, 1, '4.1.03.00', 'Pendapatan Usaha Lain Lainnya', 1, 'kredit'],
            [9, 0, 0, 2, '4.2.01.00', 'Pendapatan Non Usaha', 1, 'kredit'],
            [10, 0, 0, 3, '4.3.01.00', 'Pendapatan Luar biasa', 1, 'kredit'],
            [11, 0, 0, 1, '5.1.01.00', 'Beban Gaji dan Honor', 1, 'debet'],
            [11, 0, 0, 1, '5.1.02.00', 'Beban Tunjangan dan Bonus', 1, 'debet'],
            [11, 0, 0, 1, '5.1.03.00', 'Beban ATK dan Umum', 1, 'debet'],
            [11, 0, 0, 1, '5.1.04.00', 'Beban Rapat', 1, 'debet'],
            [11, 0, 0, 1, '5.1.05.00', 'Transportasi dan Perjalanan Dinas', 1, 'debet'],
            [11, 0, 0, 1, '5.1.06.00', 'Beban Penyisihan Cadangan', 1, 'debet'],
            [11, 0, 0, 1, '5.1.07.00', 'Beban Penyusutan dan Amortisasi', 1, 'debet'],
            [11, 0, 0, 1, '5.1.08.00', 'Beban Usaha Lainnya', 1, 'debet'],
            [11, 0, 0, 1, '5.1.09.00', 'Beban Bunga Utang', 1, 'debet'],
            [12, 0, 0, 2, '5.2.01.00', 'Beban Pemasaran', 1, 'debet'],
            [13, 0, 0, 3, '5.3.01.00', 'Beban Pajak, Bunga dan Administrasi Bank', 1, 'debet'],
            [13, 0, 0, 3, '5.3.02.00', 'Beban Penghapusan Aset Tetap', 1, 'debet'],
            [13, 0, 0, 3, '5.3.03.00', 'Beban Non Usaha Lainnya', 1, 'debet'],
            [14, 0, 0, 4, '5.4.01.00', 'Beban PPh', 1, 'debet'],
        ];

        $data = [];
        foreach ($rows as $i => $r) {
            $data[] = [
                'id' => $i + 1,
                'parent_id' => $r[0],
                'lev1' => $r[1],
                'lev2' => $r[2],
                'lev3' => $r[3],
                'lev4' => 0,
                'kode_akun' => $r[4],
                'nama_akun' => $r[5],
                'posisi' => $r[6],
                'jenis_mutasi' => $r[7],
                'created_at' => '2026-07-14 22:29:57',
                'updated_at' => '2026-07-14 22:29:57',
            ];
        }

        DB::table('akun_level3')->insertOrIgnore($data);
    }
}
