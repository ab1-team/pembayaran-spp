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
            [1, '1.0.00.00', 'Aset', 'Debet'],
            [2, '2.0.00.00', 'Utang', 'Kredit'],
            [3, '3.0.00.00', 'Modal', 'Kredit'],
            [4, '4.0.00.00', 'Pendapatan', 'Kredit'],
            [5, '5.0.00.00', 'Beban', 'Debet'],
        ];

        $l2 = [
            [11, 1, '1.1.00.00', 'Aset Lancar', 'Debet'],
            [12, 1, '1.2.00.00', 'Aset Tidak Lancar', 'Debet'],
            [13, 1, '1.3.00.00', 'Aset Lain-lain', 'Debet'],
            [21, 2, '2.1.00.00', 'Utang Jangka Pendek', 'Kredit'],
            [22, 2, '2.2.00.00', 'Utang Jangka Panjang', 'Kredit'],
            [31, 3, '3.1.00.00', 'Modal Disetor', 'Kredit'],
            [32, 3, '3.2.00.00', 'Laba Rugi', 'Kredit'],
            [41, 4, '4.1.00.00', 'Pendapatan Usaha', 'Kredit'],
            [42, 4, '4.2.00.00', 'Pendapatan Non Usaha', 'Kredit'],
            [43, 4, '4.3.00.00', 'Pendapatan Luar Biasa', 'Kredit'],
            [51, 5, '5.1.00.00', 'Beban Usaha', 'Debet'],
            [52, 5, '5.2.00.00', 'Beban Pemasaran', 'Debet'],
            [53, 5, '5.3.00.00', 'Beban Non Usaha', 'Debet'],
            [54, 5, '5.4.00.00', 'Beban Pajak', 'Debet'],
        ];

        $l3 = [
            [111, 11, 1, 1, 1, 0, '1.1.01.00', 'Kas', 1, 'Debet'],
            [112, 11, 1, 1, 2, 0, '1.1.02.00', 'Kas Setara Kas', 1, 'Debet'],
            [113, 11, 1, 1, 3, 0, '1.1.03.00', 'Piutang', 1, 'Debet'],
            [114, 11, 1, 1, 4, 0, '1.1.04.00', 'Cadangan Kerugian Piutang', 1, 'Debet'],
            [115, 11, 1, 1, 5, 0, '1.1.05.00', 'Persediaan', 1, 'Debet'],
            [116, 11, 1, 1, 6, 0, '1.1.06.00', 'Rekening Antar Kantor', 1, 'Debet'],
            [121, 12, 1, 2, 1, 0, '1.2.01.00', 'Aktiva Tetap dan Inventaris', 1, 'Debet'],
            [122, 12, 1, 2, 2, 0, '1.2.02.00', 'Akumulasi Penyusutan Aktiva Tetap dan Inventaris', 1, 'Debet'],
            [123, 12, 1, 2, 3, 0, '1.2.03.00', 'Aset Tak Berwujud', 1, 'Debet'],
            [124, 12, 1, 2, 4, 0, '1.2.04.00', 'Akumulasi Amortisasi Aset Tak Berwujud', 1, 'Debet'],
            [125, 12, 1, 2, 5, 0, '1.2.05.00', 'Konstruksi Dalam Pengerjaan', 1, 'Debet'],
            [131, 13, 1, 3, 1, 0, '1.3.01.00', 'Aset Lain-lain', 1, 'Debet'],
            [211, 21, 2, 1, 1, 0, '2.1.01.00', 'Utang Dividen', 1, 'Kredit'],
            [212, 21, 2, 1, 2, 0, '2.1.02.00', 'Utang Biaya Operasional', 1, 'Kredit'],
            [213, 21, 2, 1, 3, 0, '2.1.03.00', 'Utang Pajak', 1, 'Kredit'],
            [214, 21, 2, 1, 4, 0, '2.1.04.00', 'Simpanan Jangka Pendek', 1, 'Kredit'],
            [215, 21, 2, 1, 5, 0, '2.1.05.00', 'Utang Jangka Pendek Lainnya', 1, 'Kredit'],
            [221, 22, 2, 2, 1, 0, '2.2.01.00', 'Utang Jangka Panjang Lainnya', 1, 'Kredit'],
            [222, 22, 2, 2, 2, 0, '2.2.02.00', 'Simpanan Jangka Panjang', 1, 'Kredit'],
            [311, 31, 3, 1, 1, 0, '3.1.01.00', 'Modal Disetor', 1, 'Kredit'],
            [312, 31, 3, 1, 2, 0, '3.1.02.00', 'Modal Lain-lain', 1, 'Kredit'],
            [321, 32, 3, 2, 1, 0, '3.2.01.00', 'Laba Ditahan', 1, 'Kredit'],
            [322, 32, 3, 2, 2, 0, '3.2.02.00', 'Laba Rugi Berjalan', 1, 'Kredit'],
            [411, 41, 4, 1, 1, 0, '4.1.01.00', 'Pendapatan Usaha Utama', 1, 'Kredit'],
            [412, 41, 4, 1, 2, 0, '4.1.02.00', 'Pendapatan Usaha Lain', 1, 'Kredit'],
            [413, 41, 4, 1, 3, 0, '4.1.03.00', 'Pendapatan Usaha Lain Lainnya', 1, 'Kredit'],
            [421, 42, 4, 2, 1, 0, '4.2.01.00', 'Pendapatan Non Usaha', 1, 'Kredit'],
            [431, 43, 4, 3, 1, 0, '4.3.01.00', 'Pendapatan Luar biasa', 1, 'Kredit'],
            [511, 51, 5, 1, 1, 0, '5.1.01.00', 'Beban Gaji dan Honor', 1, 'Debet'],
            [512, 51, 5, 1, 2, 0, '5.1.02.00', 'Beban Tunjangan dan Bonus', 1, 'Debet'],
            [513, 51, 5, 1, 3, 0, '5.1.03.00', 'Beban ATK dan Umum', 1, 'Debet'],
            [514, 51, 5, 1, 4, 0, '5.1.04.00', 'Beban Rapat', 1, 'Debet'],
            [515, 51, 5, 1, 5, 0, '5.1.05.00', 'Transportasi dan Perjalanan Dinas', 1, 'Debet'],
            [516, 51, 5, 1, 6, 0, '5.1.06.00', 'Beban Penyisihan Cadangan', 1, 'Debet'],
            [517, 51, 5, 1, 7, 0, '5.1.07.00', 'Beban Penyusutan dan Amortisasi', 1, 'Debet'],
            [518, 51, 5, 1, 8, 0, '5.1.08.00', 'Beban Usaha Lainnya', 1, 'Debet'],
            [519, 51, 5, 1, 9, 0, '5.1.09.00', 'Beban Bunga Utang', 1, 'Debet'],
            [521, 52, 5, 2, 1, 0, '5.2.01.00', 'Beban Pemasaran', 1, 'Debet'],
            [531, 53, 5, 3, 1, 0, '5.3.01.00', 'Beban Pajak, Bunga dan Administrasi Bank', 1, 'Debet'],
            [532, 53, 5, 3, 2, 0, '5.3.02.00', 'Beban Penghapusan Aset Tetap', 1, 'Debet'],
            [533, 53, 5, 3, 3, 0, '5.3.03.00', 'Beban Non Usaha Lainnya', 1, 'Debet'],
            [541, 54, 5, 4, 1, 0, '5.4.01.00', 'Beban PPh', 1, 'Debet'],
        ];

        $rek = [
            ['1.1.01.00', 1, 1, 1, 1, 1, '1.1.01.01', 'Kas Tunai', 'Debet'],
            ['1.1.01.00', 1, 1, 1, 1, 2, '1.1.01.02', 'Kas Kas Kecil', 'Debet'],
            ['1.1.01.00', 1, 1, 1, 1, 3, '1.1.01.03', 'Kas di Bank BRI', 'Debet'],
            ['1.1.01.00', 1, 1, 1, 1, 5, '1.1.01.05', 'Kas di Bank Mandiri', 'Debet'],
            ['1.1.01.00', 1, 1, 1, 1, 6, '1.1.01.06', 'Kas di Bank BNI', 'Debet'],
            ['1.1.01.00', 1, 1, 1, 1, 7, '1.1.01.07', 'Kas di Bank BCA', 'Debet'],
            ['1.1.02.00', 1, 1, 2, 1, 1, '1.1.02.01', 'Deposito', 'Debet'],
            ['1.1.02.00', 1, 1, 2, 1, 2, '1.1.02.02', 'Obligasi', 'Debet'],
            ['1.1.02.00', 1, 1, 2, 1, 3, '1.1.02.03', 'Saham', 'Debet'],
            ['1.1.03.00', 1, 1, 3, 1, 2, '1.1.03.02', 'Piutang Karyawan', 'Debet'],
            ['1.1.03.00', 1, 1, 3, 1, 3, '1.1.03.03', 'Piutang Lain', 'Debet'],
            ['1.1.04.00', 1, 1, 4, 1, 1, '1.1.04.01', 'Cadangan Kerugian Piutang', 'Debet'],
            ['1.1.05.00', 1, 1, 5, 1, 1, '1.1.05.01', 'Persediaan', 'Debet'],
            ['1.1.05.00', 1, 1, 5, 1, 2, '1.1.05.02', 'Persediaan Bengkel', 'Debet'],
            ['1.1.06.00', 1, 1, 6, 1, 1, '1.1.06.01', 'Rekening Antar Kantor', 'Debet'],
            ['1.2.01.00', 1, 2, 1, 1, 1, '1.2.01.01', 'Tanah', 'Debet'],
            ['1.2.01.00', 1, 2, 1, 1, 2, '1.2.01.02', 'Gedung & Bangunan', 'Debet'],
            ['1.2.01.00', 1, 2, 1, 1, 3, '1.2.01.03', 'Kendaraan dan Mesin', 'Debet'],
            ['1.2.01.00', 1, 2, 1, 1, 4, '1.2.01.04', 'Inventaris/Peralatan', 'Debet'],
            ['1.2.02.00', 1, 2, 2, 1, 1, '1.2.02.01', 'Akumulasi penyusutan Gedung dan Bangunan', 'Debet'],
            ['1.2.02.00', 1, 2, 2, 1, 2, '1.2.02.02', 'Akumulasi penyusutan Kendaraan dan Mesin', 'Debet'],
            ['1.2.02.00', 1, 2, 2, 1, 3, '1.2.02.03', 'Akumulasi penyusutan Inventaris/Peralatan', 'Debet'],
            ['1.2.03.00', 1, 2, 3, 1, 1, '1.2.03.01', 'Biaya Pendirian Organisasi', 'Debet'],
            ['1.2.03.00', 1, 2, 3, 1, 2, '1.2.03.02', 'Lisensi', 'Debet'],
            ['1.2.03.00', 1, 2, 3, 1, 3, '1.2.03.03', 'Sewa dibayar dimuka', 'Debet'],
            ['1.2.03.00', 1, 2, 3, 1, 4, '1.2.03.04', 'Asuransi dibayar dimuka', 'Debet'],
            ['1.2.04.00', 1, 2, 4, 1, 1, '1.2.04.01', 'Akumulasi Amortisasi Biaya Pendirian Organisasi', 'Debet'],
            ['1.2.04.00', 1, 2, 4, 1, 2, '1.2.04.02', 'Akumulasi Amortisasi Lisensi', 'Debet'],
            ['1.2.04.00', 1, 2, 4, 1, 3, '1.2.04.03', 'Akumulasi Amortisasi Sewa dibayar dimuka', 'Debet'],
            ['1.2.04.00', 1, 2, 4, 1, 4, '1.2.04.04', 'Akumulasi Amortisasi Asuransi dibayar dimuka', 'Debet'],
            ['1.2.05.00', 1, 2, 5, 1, 1, '1.2.05.01', 'Konstruksi Dalam Pengerjaan dan Uang Muka', 'Debet'],
            ['1.3.01.00', 1, 3, 1, 1, 1, '1.3.01.01', 'Aset Lain-lain', 'Debet'],
            ['2.1.01.00', 2, 1, 1, 1, 1, '2.1.01.01', 'Utang Dividen Pemdes', 'Kredit'],
            ['2.1.01.00', 2, 1, 1, 1, 2, '2.1.01.02', 'Utang Dividen Masy Penyerta Modal', 'Kredit'],
            ['2.1.01.00', 2, 1, 1, 1, 3, '2.1.01.03', 'Bantuan Sosial', 'Kredit'],
            ['2.1.02.00', 2, 1, 2, 1, 1, '2.1.02.01', 'Utang Operasional', 'Kredit'],
            ['2.1.03.00', 2, 1, 3, 1, 1, '2.1.03.01', 'Utang Pajak', 'Kredit'],
            ['2.1.04.00', 2, 1, 4, 1, 1, '2.1.04.01', 'Utang Pihak Ke-3', 'Kredit'],
            ['2.1.04.00', 2, 1, 4, 1, 2, '2.1.04.02', 'Utang lain-lain jangka pendek', 'Kredit'],
            ['2.2.01.00', 2, 2, 1, 1, 1, '2.2.01.01', 'Utang Bank 1', 'Kredit'],
            ['2.2.01.00', 2, 2, 1, 1, 2, '2.2.01.02', 'Utang Bank 2', 'Kredit'],
            ['2.2.02.00', 2, 2, 2, 1, 1, '2.2.02.01', 'Utang Jangka Panjang Lainnya', 'Kredit'],
            ['3.1.01.00', 3, 1, 1, 1, 1, '3.1.01.01', 'Modal Pemdes', 'Kredit'],
            ['3.1.01.00', 3, 1, 1, 1, 2, '3.1.01.02', 'Modal Penyertaan', 'Kredit'],
            ['3.1.02.00', 3, 1, 2, 1, 1, '3.1.02.01', 'Modal Lain-lain', 'Kredit'],
            ['3.2.01.00', 3, 2, 1, 1, 1, '3.2.01.01', 'Laba Ditahan s/d Tahun lalu', 'Kredit'],
            ['3.2.02.00', 3, 2, 2, 1, 1, '3.2.02.01', 'Laba/Rugi Tahun Berjalan', 'Kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 1, '4.1.01.01', 'Pasang Baru', 'Kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 2, '4.1.01.02', 'Pendapatan Abodemen', 'Kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 3, '4.1.01.03', 'Pendapatan Komisi SPS', 'Kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 4, '4.1.01.04', 'Denda', 'Kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 5, '4.1.01.05', 'Aktivasi Ulang', 'Kredit'],
            ['4.1.01.00', 4, 1, 1, 1, 6, '4.1.01.06', 'Pendapatan Lain-lain', 'Kredit'],
            ['4.1.03.00', 4, 1, 3, 1, 99, '4.1.03.99', 'Pendapatan Usaha Lainnya', 'Kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 1, '4.2.01.01', 'Pendapatan Bunga Bank', 'Kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 2, '4.2.01.02', 'Pendapatan Hadiah', 'Kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 3, '4.2.01.03', 'Pendapatan Hibah', 'Kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 4, '4.2.01.04', 'Pertambahan Nilai Penjualan Aset', 'Kredit'],
            ['4.2.01.00', 4, 2, 1, 1, 5, '4.2.01.05', 'Pendapatan Non Usaha Lainnya', 'Kredit'],
            ['4.3.01.00', 4, 3, 1, 1, 1, '4.3.01.01', 'Pendapatan revaluasi Aset', 'Kredit'],
            ['4.3.01.00', 4, 3, 1, 1, 2, '4.3.01.02', 'Pendapatan revaluasi Saham', 'Kredit'],
            ['4.3.01.00', 4, 3, 1, 1, 3, '4.3.01.03', 'Pendapatan Non Usaha Lainnya', 'Kredit'],
            ['5.1.01.00', 5, 1, 1, 1, 1, '5.1.01.01', 'Gaji Pegawai Tetap', 'Debet'],
            ['5.1.01.00', 5, 1, 1, 1, 2, '5.1.01.02', 'Gaji pegawai teknisi', 'Debet'],
            ['5.1.01.00', 5, 1, 1, 1, 3, '5.1.01.03', 'Gaji Cater', 'Debet'],
            ['5.1.01.00', 5, 1, 1, 1, 5, '5.1.01.04', 'Honor Pembina', 'Debet'],
            ['5.1.01.00', 5, 1, 1, 1, 5, '5.1.01.05', 'Honor Pengawas', 'Debet'],
            ['5.1.02.00', 5, 1, 2, 1, 1, '5.1.02.01', 'Beban Tunjangan Pegawai', 'Debet'],
            ['5.1.02.00', 5, 1, 2, 1, 2, '5.1.02.02', 'Beban Lembur Pegawai', 'Debet'],
            ['5.1.03.00', 5, 1, 3, 1, 1, '5.1.03.01', 'Beban Administrasi dan Umum', 'Debet'],
            ['5.1.03.00', 5, 1, 3, 1, 2, '5.1.03.02', 'Beban Sewa Kantor', 'Debet'],
            ['5.1.03.00', 5, 1, 3, 1, 3, '5.1.03.03', 'Beban Pemeliharaan & Perbaikan Aset', 'Debet'],
            ['5.1.04.00', 5, 1, 4, 1, 1, '5.1.04.01', 'Beban Rapat', 'Debet'],
            ['5.1.04.00', 5, 1, 4, 1, 2, '5.1.04.02', 'Beban Peningkatan Kapasitas', 'Debet'],
            ['5.1.05.00', 5, 1, 5, 1, 1, '5.1.05.01', 'Beban Transportasi', 'Debet'],
            ['5.1.05.00', 5, 1, 5, 1, 2, '5.1.05.02', 'Beban SPPD', 'Debet'],
            ['5.1.06.00', 5, 1, 6, 1, 1, '5.1.06.01', 'Beban Penyisihan Kerugian Piutang', 'Debet'],
            ['5.1.07.00', 5, 1, 7, 1, 1, '5.1.07.01', 'Beban Penyusutan Gedung dan Bangunan', 'Debet'],
            ['5.1.07.00', 5, 1, 7, 1, 2, '5.1.07.02', 'Beban Penyusutan Kendaraan & Mesin', 'Debet'],
            ['5.1.07.00', 5, 1, 7, 1, 3, '5.1.07.03', 'Beban Penyusutan Inventaris', 'Debet'],
            ['5.1.07.00', 5, 1, 7, 1, 4, '5.1.07.04', 'Beban Amortisasi Biaya Pendirian Organisasi', 'Debet'],
            ['5.1.07.00', 5, 1, 7, 1, 5, '5.1.07.05', 'Beban Amortisasi Lisensi', 'Debet'],
            ['5.1.07.00', 5, 1, 7, 1, 6, '5.1.07.06', 'Beban Amortisasi Sewa dibayar dimuka', 'Debet'],
            ['5.1.07.00', 5, 1, 7, 1, 7, '5.1.07.07', 'Beban Amortisasi Asuransi dibayar dimuka', 'Debet'],
            ['5.1.09.00', 5, 1, 9, 1, 1, '5.1.09.01', 'Beban Operasional Lain-lain', 'Debet'],
            ['5.2.01.00', 5, 2, 1, 1, 1, '5.2.01.01', 'Beban Belanja Barang Dagang', 'Debet'],
            ['5.3.01.00', 5, 3, 1, 1, 1, '5.3.01.01', 'Beban Pajak Bank', 'Debet'],
            ['5.3.01.00', 5, 3, 1, 1, 2, '5.3.01.02', 'Beban Administrasi Bank', 'Debet'],
            ['5.3.02.00', 5, 3, 2, 1, 1, '5.3.02.01', 'Beban Penghapusan Aset Tetap dan Inventaris', 'Debet'],
            ['5.3.03.00', 5, 3, 3, 1, 1, '5.3.03.01', 'Beban Non Usaha Lainnya', 'Debet'],
            ['5.4.01.00', 5, 4, 1, 1, 1, '5.4.01.01', 'Taksiran PPh', 'Debet'],
            ['2.1.02.00', 5, 2, 1, 1, 2, '2.1.02.02', 'Utang FEE Kolektor', 'Kredit'],
            ['1.1.03.00', 5, 1, 1, 1, 3, '1.1.03.01', 'Piutang Usaha', 'Debet'],
            ['2.1.01.00', 5, 2, 1, 1, 4, '2.1.01.04', 'Utang Bonus', 'Kredit'],
            ['5.1.02.00', 5, 5, 1, 1, 2, '5.1.02.03', 'Beban Bonus Prestasi Kerja', 'Debet'],
            ['5.1.02.00', 5, 5, 1, 1, 2, '5.1.02.04', 'Beban FEE Kolektor', 'Debet'],
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
