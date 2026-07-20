<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach (['users', 'siswa', 'anggota_kelas', 'spp', 'kelas', 'jurusan', 'ruangan', 'kurikulum', 'tahun_akademik'] as $t) {
            DB::table($t)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // JURUSAN
        DB::table('jurusan')->insert([
            ['nama' => 'Teknik Komputer Jaringan', 'kode_jurusan' => 'TKJ', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Multimedia',                'kode_jurusan' => 'MM',  'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // TAHUN AKADEMIK
        DB::table('tahun_akademik')->insert([
            ['nama_tahun' => '2025/2026', 'keterangan' => 'Genap', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['nama_tahun' => '2024/2025', 'keterangan' => 'Ganjil','status' => 'nonaktif', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // RUANGAN
        DB::table('ruangan')->insert([
            ['kode_gedung' => 'G1', 'kode_ruangan' => 'R1', 'nama_ruangan' => 'Ruang 1', 'kapasitas_belajar' => '30', 'kapasitas_ujian' => '30', 'keterangan' => '-', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
            ['kode_gedung' => 'G1', 'kode_ruangan' => 'R2', 'nama_ruangan' => 'Ruang 2', 'kapasitas_belajar' => '30', 'kapasitas_ujian' => '30', 'keterangan' => '-', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // KELAS
        DB::table('kelas')->insert([
            ['kode_kelas' => 'X-TKJ-1', 'nama_kelas' => 'X TKJ 1', 'tingkat' => 'X',   'kode_kurikulum' => 'K-2025', 'created_at' => now(), 'updated_at' => now()],
            ['kode_kelas' => 'XI-MM-1', 'nama_kelas' => 'XI MM 1', 'tingkat' => 'XI',  'kode_kurikulum' => 'K-2024', 'created_at' => now(), 'updated_at' => now()],
            ['kode_kelas' => 'XII-TKJ-1','nama_kelas' => 'XII TKJ 1','tingkat' => 'XII','kode_kurikulum' => 'K-2023', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // KURIKULUM
        DB::table('kurikulum')->insert([
            ['nama_kurikulum' => 'Kurikulum 2025', 'status' => 'aktif', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // USER ADMIN
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@local',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // SISWA (10) + anggota_kelas + spp bulanan
        $names = [
            ['Ahmad Fauzi',    'L', 'TKJ'],
            ['Budi Santoso',   'L', 'TKJ'],
            ['Citra Dewi',     'P', 'MM'],
            ['Dewi Lestari',   'P', 'MM'],
            ['Eko Prabowo',    'L', 'TKJ'],
            ['Fitriani',       'P', 'MM'],
            ['Galih Pratama',  'L', 'TKJ'],
            ['Hanifah',        'P', 'MM'],
            ['Indra Kurnia',   'L', 'TKJ'],
            ['Joko Riyanto',   'L', 'TKJ'],
        ];

        $tahunSekarang = '2025/2026';
        $bulanSPP = ['2025-07-15','2025-08-15','2025-09-15','2025-10-15','2025-11-15','2025-12-15',
                     '2026-01-15','2026-02-15','2026-03-15','2026-04-15','2026-05-15','2026-06-15'];

        foreach ($names as $i => [$nama, $jk, $jr]) {
            $idUser = DB::table('users')->insertGetId([
                'name' => $nama,
                'email' => 'siswa' . ($i+1) . '@local',
                'username' => 'siswa' . ($i+1),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $tingkat = $jr === 'TKJ' ? (($i % 3 === 0) ? 'XII' : (($i % 3 === 1) ? 'XI' : 'X')) : 'XI';
            $kodeKelas = $tingkat . '-' . $jr . '-1';

            $idSiswa = DB::table('siswa')->insertGetId([
                'nipd' => str_pad((string)(1000 + $i), 4, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'tanggal_masuk' => '2024-07-15',
                'tahun_akademik' => 1,
                'nisn' => '00' . str_pad((string)(1000000 + $i), 7, '0', STR_PAD_LEFT),
                'nama' => $nama,
                'jenis_kelamin' => $jk,
                'nik' => '3201' . str_pad((string)(1000000000 + $i), 10, '0', STR_PAD_LEFT),
                'tanggal_lahir' => '2008-0' . ($i+1) . '-15',
                'tempat_lahir' => 'Jakarta',
                'agama' => 'Islam',
                'alamat' => 'Jl. Contoh No. ' . ($i+1),
                'kebutuhan_khusus' => '-',
                'rt' => '001',
                'rw' => '002',
                'dusun' => '-',
                'kelurahan' => 'Kelurahan ' . ($i+1),
                'kecamatan' => 'Kecamatan ' . ($i+1),
                'kode_pos' => '12345',
                'jenis_tinggal' => 'orang_tua',
                'alat_transportasi' => 'Sepeda Motor',
                'telepon' => '02112345' . str_pad((string)$i, 3, '0', STR_PAD_LEFT),
                'hp' => '0812345678' . substr((string)($i*9), 0, 2),
                'email' => 'siswa' . ($i+1) . '@local',
                'skhun' => 'SKHUN' . ($i+1),
                'penerima_kps' => 'Tidak',
                'no_kps' => '-',
                'foto' => null,
                'angkatan' => '2024',
                'status_awal' => 'baru',
                'status_siswa' => 'aktif',
                'tingkat' => $tingkat,
                'kode_kelas' => $kodeKelas,
                'kode_jurusan' => $jr,
                'ruang' => $i % 2 === 0 ? 'R1' : 'R2',
                'spp_nominal' => '300000',
                'id_user' => (string)$idUser,
                'nama_ayah' => 'Bpk. ' . explode(' ', $nama)[0],
                'tahun_lahir_ayah' => '1975',
                'pendidikan_ayah' => 'SMA',
                'pekerjaan_ayah' => 'Wiraswasta',
                'penghasilan_ayah' => '3000000',
                'kebutuhan_khusus_ayah' => '-',
                'no_telepon_ayah' => '0811111111' . substr((string)($i*3), 0, 2),
                'nama_ibu' => 'Ibu ' . explode(' ', $nama)[0],
                'tahun_lahir_ibu' => '1978',
                'pendidikan_ibu' => 'SMA',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'penghasilan_ibu' => '0',
                'kebutuhan_khusus_ibu' => '-',
                'no_telepon_ibu' => '0822222222' . substr((string)($i*7), 0, 2),
                'nama_wali' => '-',
                'tahun_lahir_wali' => '-',
                'pendidikan_wali' => '-',
                'pekerjaan_wali' => '-',
                'penghasilan_wali' => '-',
                'kebutuhan_khusus_wali' => '-',
                'no_telepon_wali' => '-',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $idAk = DB::table('anggota_kelas')->insertGetId([
                'id_siswa' => $idSiswa,
                'tahun_akademik' => $tahunSekarang,
                'tingkat' => $tingkat,
                'kode_kelas' => $kodeKelas,
                'tgl_masuk' => '2024-07-15',
                'tgl_keluar' => '',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $idSiswaAk = (int) DB::table('anggota_kelas')->where('id', $idAk)->value('id_siswa');

            foreach ($bulanSPP as $ke => $tgl) {

                DB::table('spp')->insert([
                    'kode'          => date('ym', strtotime($tgl)) . $idSiswaAk,
                    'tanggal'       => $tgl,
                    'anggota_kelas' => (string) $idAk,
                    'nominal'       => '300000',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }
    }
}
