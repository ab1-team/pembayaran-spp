<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RekeningSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('akun_level1')->exists()
            && DB::table('akun_level2')->exists()
            && DB::table('akun_level3')->exists()
            && DB::table('rekening')->exists()) {
            return;
        }

        $now = now();

        $l1 = [
            [1, '1.0.00.00', 'Aset', 'debet'],
            [2, '2.0.00.00', 'Utang', 'kredit'],
            [3, '3.0.00.00', 'Modal', 'kredit'],
            [4, '4.0.00.00', 'Pendapatan', 'kredit'],
            [5, '5.0.00.00', 'Beban', 'debet'],
        ];

        $l2 = [
            [11, 1, '1.1.00.00', 'Aset Lancar', 'debet'],
            [12, 1, '1.2.00.00', 'Aset Tidak Lancar', 'debet'],
            [13, 1, '1.3.00.00', 'Aset Lain-lain', 'debet'],
            [21, 2, '2.1.00.00', 'Utang Jangka Pendek', 'kredit'],
            [22, 2, '2.2.00.00', 'Utang Jangka Panjang', 'kredit'],
            [31, 3, '3.1.00.00', 'Modal Disetor', 'kredit'],
            [32, 3, '3.2.00.00', 'Laba Rugi', 'kredit'],
            [41, 4, '4.1.00.00', 'Pendapatan Usaha', 'kredit'],
            [42, 4, '4.2.00.00', 'Pendapatan Non Usaha', 'kredit'],
            [43, 4, '4.3.00.00', 'Pendapatan Luar Biasa', 'kredit'],
            [51, 5, '5.1.00.00', 'Beban Usaha', 'debet'],
            [52, 5, '5.2.00.00', 'Beban Pemasaran', 'debet'],
            [53, 5, '5.3.00.00', 'Beban Non Usaha', 'debet'],
            [54, 5, '5.4.00.00', 'Beban Pajak', 'debet'],
        ];

        $l3 = [
            [111, 11, 1, 1, 1, 0, '1.1.01.00', 'Kas', 1, 'debet'],
            [112, 11, 1, 1, 2, 0, '1.1.02.00', 'Kas Setara Kas', 1, 'debet'],
            [113, 11, 1, 1, 3, 0, '1.1.03.00', 'Piutang', 1, 'debet'],
            [114, 11, 1, 1, 4, 0, '1.1.04.00', 'Cadangan Kerugian Piutang', 1, 'debet'],
            [115, 11, 1, 1, 5, 0, '1.1.05.00', 'Persediaan', 1, 'debet'],
            [116, 11, 1, 1, 6, 0, '1.1.06.00', 'Rekening Antar Kantor', 1, 'debet'],
            [121, 12, 1, 2, 1, 0, '1.2.01.00', 'Aktiva Tetap dan Inventaris', 1, 'debet'],
            [122, 12, 1, 2, 2, 0, '1.2.02.00', 'Akumulasi Penyusutan Aktiva Tetap dan Inventaris', 1, 'debet'],
            [123, 12, 1, 2, 3, 0, '1.2.03.00', 'Aset Tak Berwujud', 1, 'debet'],
            [124, 12, 1, 2, 4, 0, '1.2.04.00', 'Akumulasi Amortisasi Aset Tak Berwujud', 1, 'debet'],
            [125, 12, 1, 2, 5, 0, '1.2.05.00', 'Konstruksi Dalam Pengerjaan', 1, 'debet'],
            [131, 13, 1, 3, 1, 0, '1.3.01.00', 'Aset Lain-lain', 1, 'debet'],
            [211, 21, 2, 1, 1, 0, '2.1.01.00', 'Utang Dividen', 1, 'kredit'],
            [212, 21, 2, 1, 2, 0, '2.1.02.00', 'Utang Biaya Operasional', 1, 'kredit'],
            [213, 21, 2, 1, 3, 0, '2.1.03.00', 'Utang Pajak', 1, 'kredit'],
            [214, 21, 2, 1, 4, 0, '2.1.04.00', 'Simpanan Jangka Pendek', 1, 'kredit'],
            [215, 21, 2, 1, 5, 0, '2.1.05.00', 'Utang Jangka Pendek Lainnya', 1, 'kredit'],
            [221, 22, 2, 2, 1, 0, '2.2.01.00', 'Utang Jangka Panjang Lainnya', 1, 'kredit'],
            [222, 22, 2, 2, 2, 0, '2.2.02.00', 'Simpanan Jangka Panjang', 1, 'kredit'],
            [311, 31, 3, 1, 1, 0, '3.1.01.00', 'Modal Disetor', 1, 'kredit'],
            [312, 31, 3, 1, 2, 0, '3.1.02.00', 'Modal Lain-lain', 1, 'kredit'],
            [321, 32, 3, 2, 1, 0, '3.2.01.00', 'Laba Ditahan', 1, 'kredit'],
            [322, 32, 3, 2, 2, 0, '3.2.02.00', 'Laba Rugi Berjalan', 1, 'kredit'],
            [411, 41, 4, 1, 1, 0, '4.1.01.00', 'Pendapatan Usaha Utama', 1, 'kredit'],
            [412, 41, 4, 1, 2, 0, '4.1.02.00', 'Pendapatan Usaha Lain', 1, 'kredit'],
            [413, 41, 4, 1, 3, 0, '4.1.03.00', 'Pendapatan Usaha Lain Lainnya', 1, 'kredit'],
            [421, 42, 4, 2, 1, 0, '4.2.01.00', 'Pendapatan Non Usaha', 1, 'kredit'],
            [431, 43, 4, 3, 1, 0, '4.3.01.00', 'Pendapatan Luar biasa', 1, 'kredit'],
            [511, 51, 5, 1, 1, 0, '5.1.01.00', 'Beban Gaji dan Honor', 1, 'debet'],
            [512, 51, 5, 1, 2, 0, '5.1.02.00', 'Beban Tunjangan dan Bonus', 1, 'debet'],
            [513, 51, 5, 1, 3, 0, '5.1.03.00', 'Beban ATK dan Umum', 1, 'debet'],
            [514, 51, 5, 1, 4, 0, '5.1.04.00', 'Beban Rapat', 1, 'debet'],
            [515, 51, 5, 1, 5, 0, '5.1.05.00', 'Transportasi dan Perjalanan Dinas', 1, 'debet'],
            [516, 51, 5, 1, 6, 0, '5.1.06.00', 'Beban Penyisihan Cadangan', 1, 'debet'],
            [517, 51, 5, 1, 7, 0, '5.1.07.00', 'Beban Penyusutan dan Amortisasi', 1, 'debet'],
            [518, 51, 5, 1, 8, 0, '5.1.08.00', 'Beban Usaha Lainnya', 1, 'debet'],
            [519, 51, 5, 1, 9, 0, '5.1.09.00', 'Beban Bunga Utang', 1, 'debet'],
            [521, 52, 5, 2, 1, 0, '5.2.01.00', 'Beban Pemasaran', 1, 'debet'],
            [531, 53, 5, 3, 1, 0, '5.3.01.00', 'Beban Pajak, Bunga dan Administrasi Bank', 1, 'debet'],
            [532, 53, 5, 3, 2, 0, '5.3.02.00', 'Beban Penghapusan Aset Tetap', 1, 'debet'],
            [533, 53, 5, 3, 3, 0, '5.3.03.00', 'Beban Non Usaha Lainnya', 1, 'debet'],
            [541, 54, 5, 4, 1, 0, '5.4.01.00', 'Beban PPh', 1, 'debet'],
        ];

        $rek = [
            ['1.1.01.00', 1, 1, 1, 1, 1, '1.1.01.01', 'Kas Tunai', 'debet'],
            ['1.1.01.00', 1, 1, 1, 1, 2, '1.1.01.02', 'Kas Kas Kecil', 'debet'],
            ['1.1.01.00', 1, 1, 1, 1, 3, '1.1.01.03', 'Kas di Bank BRI', 'debet'],
            ['1.1.01.00', 1, 1, 1, 1, 5, '1.1.01.05', 'Kas di Bank Mandiri', 'debet'],
            ['1.1.01.00', 1, 1, 1, 1, 6, '1.1.01.06', 'Kas di Bank BNI', 'debet'],
            ['1.1.01.00', 1, 1, 1, 1, 7, '1.1.01.07', 'Kas di Bank BCA', 'debet'],
            ['1.1.02.00', 1, 1, 2, 1, 1, '1.1.02.01', 'Deposito', 'debet'],
            ['1.1.02.00', 1, 1, 2, 1, 2, '1.1.02.02', 'Obligasi', 'debet'],
            ['1.1.02.00', 1, 1, 2, 1, 3, '1.1.02.03', 'Saham', 'debet'],
            ['1.1.03.00', 1, 1, 3, 1, 2, '1.1.03.02', 'Piutang Karyawan', 'debet'],
            ['1.1.03.00', 1, 1, 3, 1, 3, '1.1.03.03', 'Piutang Lain', 'debet'],
            ['1.1.04.00', 1, 1, 4, 1, 1, '1.1.04.01', 'Cadangan Kerugian Piutang', 'debet'],
            ['1.1.05.00', 1, 1, 5, 1, 1, '1.1.05.01', 'Persediaan', 'debet'],
            ['1.1.05.00', 1, 1, 5, 1, 2, '1.1.05.02', 'Persediaan Bengkel', 'debet'],
            ['1.1.06.00', 1, 1, 6, 1, 1, '1.1.06.01', 'Rekening Antar Kantor', 'debet'],
            ['1.2.01.00', 1, 2, 1, 1, 1, '1.2.01.01', 'Tanah', 'debet'],
            ['1.2.01.00', 1, 2, 1, 1, 2, '1.2.01.02', 'Gedung & Bangunan', 'debet'],
            ['1.2.01.00', 1, 2, 1, 1, 3, '1.2.01.03', 'Kendaraan dan Mesin', 'debet'],
            ['1.2.01.00', 1, 2, 1, 1, 4, '1.2.01.04', 'Inventaris/Peralatan', 'debet'],
            ['1.2.02.00', 1, 2, 2, 1, 1, '1.2.02.01', 'Akumulasi penyusutan Gedung dan Bangunan', 'debet'],
            ['1.2.02.00', 1, 2, 2, 1, 2, '1.2.02.02', 'Akumulasi penyusutan Kendaraan dan Mesin', 'debet'],
            ['1.2.02.00', 1, 2, 2, 1, 3, '1.2.02.03', 'Akumulasi penyusutan Inventaris/Peralatan', 'debet'],
            ['1.2.03.00', 1, 2, 3, 1, 1, '1.2.03.01', 'Biaya Pendirian Organisasi', 'debet'],
            ['1.2.03.00', 1, 2, 3, 1, 2, '1.2.03.02', 'Lisensi', 'debet'],
            ['1.2.03.00', 1, 2, 3, 1, 3, '1.2.03.03', 'Sewa dibayar dimuka', 'debet'],
            ['1.2.03.00', 1, 2, 3, 1, 4, '1.2.03.04', 'Asuransi dibayar dimuka', 'debet'],
            ['1.2.04.00', 1, 2, 4, 1, 1, '1.2.04.01', 'Akumulasi Amortisasi Biaya Pendirian Organisasi', 'debet'],
            ['1.2.04.00', 1, 2, 4, 1, 2, '1.2.04.02', 'Akumulasi Amortisasi Lisensi', 'debet'],
            ['1.2.04.00', 1, 2, 4, 1, 3, '1.2.04.03', 'Akumulasi Amortisasi Sewa dibayar dimuka', 'debet'],
            ['1.2.04.00', 1, 2, 4, 1, 4, '1.2.04.04', 'Akumulasi Amortisasi Asuransi dibayar dimuka', 'debet'],
            ['1.2.05.00', 1, 2, 5, 1, 1, '1.2.05.01', 'Konstruksi Dalam Pengerjaan dan Uang Muka', 'debet'],
            ['1.3.01.00', 1, 3, 1, 1, 1, '1.3.01.01', 'Aset Lain-lain', 'debet'],
            ['2.1.01.00', 2, 1, 1, 1, 1, '2.1.01.01', 'Utang Dividen Pemdes', 'kredit'],
            ['2.1.01.00', 2, 1, 1, 1, 2, '2.1.01.02', 'Utang Dividen Masy Penyerta Modal', 'kredit'],
            ['2.1.01.00', 2, 1, 1, 1, 3, '2.1.01.03', 'Bantuan Sosial', 'kredit'],
            ['2.1.02.00', 2, 1, 2, 1, 1, '2.1.02.01', 'Utang Operasional', 'kredit'],
            ['2.1.03.00', 2, 1, 3, 1, 1, '2.1.03.01', 'Utang Pajak', 'kredit'],
            ['2.1.04.00', 2, 1, 4, 1, 1, '2.1.04.01', 'Utang Pihak Ke-3', 'kredit'],
            ['2.1.04.00', 2, 1, 4, 1, 2, '2.1.04.02', 'Utang lain-lain jangka pendek', 'kredit'],
            ['2.2.01.00', 2, 2, 1, 1, 1, '2.2.01.01', 'Utang Bank 1', 'kredit'],
            ['2.2.01.00', 2, 2, 1, 1, 2, '2.2.01.02', 'Utang Bank 2', 'kredit'],
            ['2.2.02.00', 2, 2, 2, 1, 1, '2.2.02.01', 'Utang Jangka Panjang Lainnya', 'kredit'],
            ['3.1.01.00', 3, 1, 1, 1, 1, '3.1.01.01', 'Modal Pemdes', 'kredit'],
            ['3.1.01.00', 3, 1, 1, 1, 2, '3.1.01.02', 'Modal Penyertaan', 'kredit'],
            ['3.1.02.00', 3, 1, 2, 1, 1, '3.1.02.01', 'Modal Lain-lain', 'kredit'],
            ['3.2.01.00', 3, 2, 1, 1, 1, '3.2.01.01', 'Laba Ditahan s/d Tahun lalu', 'kredit'],
            ['3.2.02.00', 3, 2, 2, 1, 1, '3.2.02.01', 'Laba/Rugi Tahun Berjalan', 'kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 1, '4.1.01.01', 'Pasang Baru', 'kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 2, '4.1.01.02', 'Daftar Ulang', 'kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 3, '4.1.01.03', 'Pendapatan Komisi SPS', 'kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 4, '4.1.01.04', 'Denda', 'kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 5, '4.1.01.05', 'Aktivasi Ulang', 'kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 6, '4.1.01.06', 'Pendapatan Lain-lain', 'kredit'],
            ['4.1.03.00', 4, 1, 3, 1, 99, '4.1.03.99', 'Pendapatan Usaha Lainnya', 'kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 1, '4.2.01.01', 'Pendapatan Bunga Bank', 'kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 2, '4.2.01.02', 'Pendapatan Hadiah', 'kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 3, '4.2.01.03', 'Pendapatan Hibah', 'kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 4, '4.2.01.04', 'Pertambahan Nilai Penjualan Aset', 'kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 5, '4.2.01.05', 'Pendapatan Non Usaha Lainnya', 'kredit'],
            ['4.3.01.00', 4, 3, 1, 1, 1, '4.3.01.01', 'Pendapatan revaluasi Aset', 'kredit'],
            ['4.3.01.00', 4, 3, 1, 1, 2, '4.3.01.02', 'Pendapatan revaluasi Saham', 'kredit'],
            ['4.3.01.00', 4, 3, 1, 1, 3, '4.3.01.03', 'Pendapatan Non Usaha Lainnya', 'kredit'],
            ['5.1.01.00', 5, 1, 1, 1, 1, '5.1.01.01', 'Gaji Pegawai Tetap', 'debet'],
            ['5.1.01.00', 5, 1, 1, 1, 2, '5.1.01.02', 'Gaji pegawai teknisi', 'debet'],
            ['5.1.01.00', 5, 1, 1, 1, 3, '5.1.01.03', 'Gaji Cater', 'debet'],
            ['5.1.01.00', 5, 1, 1, 1, 5, '5.1.01.04', 'Honor Pembina', 'debet'],
            ['5.1.01.00', 5, 1, 1, 1, 5, '5.1.01.05', 'Honor Pengawas', 'debet'],
            ['5.1.02.00', 5, 1, 2, 1, 1, '5.1.02.01', 'Beban Tunjangan Pegawai', 'debet'],
            ['5.1.02.00', 5, 1, 2, 1, 2, '5.1.02.02', 'Beban Lembur Pegawai', 'debet'],
            ['5.1.03.00', 5, 1, 3, 1, 1, '5.1.03.01', 'Beban Administrasi dan Umum', 'debet'],
            ['5.1.03.00', 5, 1, 3, 1, 2, '5.1.03.02', 'Beban Sewa Kantor', 'debet'],
            ['5.1.03.00', 5, 1, 3, 1, 3, '5.1.03.03', 'Beban Pemeliharaan & Perbaikan Aset', 'debet'],
            ['5.1.04.00', 5, 1, 4, 1, 1, '5.1.04.01', 'Beban Rapat', 'debet'],
            ['5.1.04.00', 5, 1, 4, 1, 2, '5.1.04.02', 'Beban Peningkatan Kapasitas', 'debet'],
            ['5.1.05.00', 5, 1, 5, 1, 1, '5.1.05.01', 'Beban Transportasi', 'debet'],
            ['5.1.05.00', 5, 1, 5, 1, 2, '5.1.05.02', 'Beban SPPD', 'debet'],
            ['5.1.06.00', 5, 1, 6, 1, 1, '5.1.06.01', 'Beban Penyisihan Kerugian Piutang', 'debet'],
            ['5.1.07.00', 5, 1, 7, 1, 1, '5.1.07.01', 'Beban Penyusutan Gedung dan Bangunan', 'debet'],
            ['5.1.07.00', 5, 1, 7, 1, 2, '5.1.07.02', 'Beban Penyusutan Kendaraan & Mesin', 'debet'],
            ['5.1.07.00', 5, 1, 7, 1, 3, '5.1.07.03', 'Beban Penyusutan Inventaris', 'debet'],
            ['5.1.07.00', 5, 1, 7, 1, 4, '5.1.07.04', 'Beban Amortisasi Biaya Pendirian Organisasi', 'debet'],
            ['5.1.07.00', 5, 1, 7, 1, 5, '5.1.07.05', 'Beban Amortisasi Lisensi', 'debet'],
            ['5.1.07.00', 5, 1, 7, 1, 6, '5.1.07.06', 'Beban Amortisasi Sewa dibayar dimuka', 'debet'],
            ['5.1.07.00', 5, 1, 7, 1, 7, '5.1.07.07', 'Beban Amortisasi Asuransi dibayar dimuka', 'debet'],
            ['5.1.09.00', 5, 1, 9, 1, 1, '5.1.09.01', 'Beban Operasional Lain-lain', 'debet'],
            ['5.2.01.00', 5, 2, 1, 1, 1, '5.2.01.01', 'Beban Belanja Barang Dagang', 'debet'],
            ['5.3.01.00', 5, 3, 1, 1, 1, '5.3.01.01', 'Beban Pajak Bank', 'debet'],
            ['5.3.01.00', 5, 3, 1, 1, 2, '5.3.01.02', 'Beban Administrasi Bank', 'debet'],
            ['5.3.02.00', 5, 3, 2, 1, 1, '5.3.02.01', 'Beban Penghapusan Aset Tetap dan Inventaris', 'debet'],
            ['5.3.03.00', 5, 3, 3, 1, 1, '5.3.03.01', 'Beban Non Usaha Lainnya', 'debet'],
            ['5.4.01.00', 5, 4, 1, 1, 1, '5.4.01.01', 'Taksiran PPh', 'debet'],
            ['2.1.02.00', 5, 2, 1, 1, 2, '2.1.02.02', 'Utang FEE Kolektor', 'kredit'],
            ['1.1.03.00', 5, 1, 1, 1, 3, '1.1.03.01', 'Piutang Usaha', 'debet'],
            ['2.1.01.00', 5, 2, 1, 1, 4, '2.1.01.04', 'Utang Bonus', 'kredit'],
            ['5.1.02.00', 5, 5, 1, 1, 2, '5.1.02.03', 'Beban Bonus Prestasi Kerja', 'debet'],
            ['5.1.02.00', 5, 5, 1, 1, 2, '5.1.02.04', 'Beban FEE Kolektor', 'debet'],
        ];

        $existingL1 = DB::table('akun_level1')->pluck('id', 'kode_akun')->all();
        $existingL2 = DB::table('akun_level2')->pluck('id', 'kode_akun')->all();
        $existingL3 = DB::table('akun_level3')->pluck('id', 'kode_akun')->all();

        foreach ($l1 as $r) {
            if (isset($existingL1[$r[1]])) continue;
            $id = DB::table('akun_level1')->insertGetId([
                'lev1' => $r[0], 'lev2' => 0, 'lev3' => 0, 'lev4' => 0,
                'kode_akun' => $r[1], 'nama_akun' => $r[2],
                'jenis_mutasi' => $r[3], 'created_at' => $now, 'updated_at' => $now,
            ]);
            $existingL1[$r[1]] = $id;
        }

        $l1OldKode = []; foreach ($l1 as $r) { $l1OldKode[$r[0]] = $r[1]; }
        $l2OldKode = []; foreach ($l2 as $r) { $l2OldKode[$r[0]] = $r[2]; }

        foreach ($l2 as $r) {
            if (isset($existingL2[$r[2]])) continue;
            $parentKode = $l1OldKode[$r[1]] ?? null;
            $parent = $existingL1[$parentKode] ?? null;
            $id = DB::table('akun_level2')->insertGetId([
                'parent_id' => $parent,
                'lev1' => 0, 'lev2' => $r[1], 'lev3' => 0, 'lev4' => 0,
                'kode_akun' => $r[2], 'nama_akun' => $r[3],
                'jenis_mutasi' => $r[4], 'created_at' => $now, 'updated_at' => $now,
            ]);
            $existingL2[$r[2]] = $id;
        }

        foreach ($l3 as $r) {
            if (isset($existingL3[$r[6]])) continue;
            $parentKode = $l2OldKode[$r[1]] ?? null;
            $parent = $existingL2[$parentKode] ?? null;
            $id = DB::table('akun_level3')->insertGetId([
                'parent_id' => $parent,
                'lev1' => 0, 'lev2' => 0, 'lev3' => $r[3], 'lev4' => 0,
                'kode_akun' => $r[6], 'nama_akun' => $r[7],
                'posisi' => $r[8], 'jenis_mutasi' => $r[9],
                'created_at' => $now, 'updated_at' => $now,
            ]);
            $existingL3[$r[6]] = $id;
        }

        foreach ($rek as $r) {
            $parentKode = $r[0];
            $kode = $r[6];
            if (DB::table('rekening')->where('kode_akun', $kode)->exists()) continue;
            $parent = $existingL3[$parentKode] ?? null;
            if (!$parent) continue;
            DB::table('rekening')->insert([
                'parent_id' => $parent,
                'lev1' => $r[1], 'lev2' => $r[2], 'lev3' => $r[3], 'lev4' => $r[4],
                'kode_akun' => $kode, 'nama_akun' => $r[7],
                'jenis_mutasi' => $r[8],
                'tgl_nonaktif' => null,
                'saldo' => 0,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }
}
