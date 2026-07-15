<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('siswa')->count() >= 20) {
            return;
        }

        $now = now();

        $jurusanList = [
            ['kode_jurusan' => 'TKJ',  'nama' => 'Teknik Komputer dan Jaringan'],
            ['kode_jurusan' => 'MM',   'nama' => 'Multimedia'],
            ['kode_jurusan' => 'AKL',  'nama' => 'Akuntansi dan Keuangan Lembaga'],
            ['kode_jurusan' => 'OTKP', 'nama' => 'Otomatisasi dan Tata Kelola Perkantoran'],
        ];
        foreach ($jurusanList as $j) {
            if (!DB::table('jurusan')->where('kode_jurusan', $j['kode_jurusan'])->exists()) {
                DB::table('jurusan')->insert([
                    'kode_jurusan' => $j['kode_jurusan'], 'nama' => $j['nama'],
                    'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        $kurikulumList = [
            ['kode_kurikulum' => 'K-MERDEKA', 'nama_kurikulum' => 'Kurikulum Merdeka'],
            ['kode_kurikulum' => 'K-2013', 'nama_kurikulum' => 'Kurikulum 2013'],
        ];
        foreach ($kurikulumList as $k) {
            if (!DB::table('kurikulum')->where('kode_kurikulum', $k['kode_kurikulum'])->exists()) {
                DB::table('kurikulum')->insert([
                    'kode_kurikulum' => $k['kode_kurikulum'],
                    'nama_kurikulum' => $k['nama_kurikulum'], 'status' => 'aktif',
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        $tahunList = [
            ['nama_tahun' => '2023/2024', 'keterangan' => 'Tahun Pelajaran 2023/2024', 'status' => 'nonaktif'],
            ['nama_tahun' => '2024/2025', 'keterangan' => 'Tahun Pelajaran 2024/2025', 'status' => 'nonaktif'],
            ['nama_tahun' => '2025/2026', 'keterangan' => 'Tahun Pelajaran 2025/2026', 'status' => 'aktif'],
        ];
        foreach ($tahunList as $t) {
            if (!DB::table('tahun_akademik')->where('nama_tahun', $t['nama_tahun'])->exists()) {
                DB::table('tahun_akademik')->insert([
                    'nama_tahun' => $t['nama_tahun'], 'keterangan' => $t['keterangan'],
                    'status' => $t['status'], 'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }
        $tahunAktifId = DB::table('tahun_akademik')->where('nama_tahun', '2025/2026')->value('id');
        $kurikulumKode = DB::table('kurikulum')->where('kode_kurikulum', 'K-MERDEKA')->value('kode_kurikulum');

        $ruanganList = [
            ['kode_gedung' => 'A', 'kode_ruangan' => 'A-101', 'nama_ruangan' => 'Ruang Kelas X TKJ 1', 'kapasitas_belajar' => '36', 'kapasitas_ujian' => '32', 'keterangan' => 'Lantai 1'],
            ['kode_gedung' => 'A', 'kode_ruangan' => 'A-102', 'nama_ruangan' => 'Ruang Kelas X MM 1', 'kapasitas_belajar' => '36', 'kapasitas_ujian' => '32', 'keterangan' => 'Lantai 1'],
            ['kode_gedung' => 'B', 'kode_ruangan' => 'B-201', 'nama_ruangan' => 'Ruang Kelas XI AKL 1', 'kapasitas_belajar' => '36', 'kapasitas_ujian' => '32', 'keterangan' => 'Lantai 2'],
            ['kode_gedung' => 'B', 'kode_ruangan' => 'B-202', 'nama_ruangan' => 'Ruang Kelas XI OTKP 1', 'kapasitas_belajar' => '36', 'kapasitas_ujian' => '32', 'keterangan' => 'Lantai 2'],
        ];
        foreach ($ruanganList as $r) {
            if (!DB::table('ruangan')->where('kode_ruangan', $r['kode_ruangan'])->exists()) {
                DB::table('ruangan')->insert(array_merge($r, [
                    'status' => 'aktif', 'created_at' => $now, 'updated_at' => $now,
                ]));
            }
        }

        $kelasList = [
            ['kode_kelas' => 'X-TKJ-1',  'nama_kelas' => 'X TKJ 1',  'tingkat' => '10', 'kode_kurikulum' => $kurikulumKode],
            ['kode_kelas' => 'X-MM-1',   'nama_kelas' => 'X MM 1',   'tingkat' => '10', 'kode_kurikulum' => $kurikulumKode],
            ['kode_kelas' => 'XI-AKL-1', 'nama_kelas' => 'XI AKL 1', 'tingkat' => '11', 'kode_kurikulum' => $kurikulumKode],
            ['kode_kelas' => 'XI-OTKP-1','nama_kelas' => 'XI OTKP 1','tingkat' => '11', 'kode_kurikulum' => $kurikulumKode],
        ];
        foreach ($kelasList as $k) {
            if (!DB::table('kelas')->where('kode_kelas', $k['kode_kelas'])->exists()) {
                DB::table('kelas')->insert(array_merge($k, [
                    'created_at' => $now, 'updated_at' => $now,
                ]));
            }
        }

        $siswaData = [
            ['25001', 'Ahmad Fauzan',     'L', 'Sragen',   '2010-03-12', 'X-TKJ-1',  'TKJ',  'A-101', 'Islam',     'orang_tua'],
            ['25002', 'Bintang Wisesa',   'L', 'Karangmalang','2010-07-22','X-TKJ-1','TKJ',  'A-101', 'Islam',     'orang_tua'],
            ['25003', 'Citra Lestari',    'P', 'Sragen',   '2010-01-05', 'X-TKJ-1',  'TKJ',  'A-101', 'Islam',     'wali'],
            ['25004', 'Dewi Anjani',      'P', 'Sragen',   '2010-11-18', 'X-TKJ-1',  'TKJ',  'A-101', 'Kristen',   'orang_tua'],
            ['25005', 'Eka Pratama',      'L', 'Sragen',   '2010-09-30', 'X-TKJ-1',  'TKJ',  'A-101', 'Islam',     'orang_tua'],

            ['25006', 'Fajar Nugroho',    'L', 'Sragen',   '2010-04-14', 'X-MM-1',   'MM',   'A-102', 'Islam',     'kost'],
            ['25007', 'Gita Permata',     'P', 'Sragen',   '2010-08-21', 'X-MM-1',   'MM',   'A-102', 'Islam',     'orang_tua'],
            ['25008', 'Hadi Wibowo',      'L', 'Sragen',   '2010-02-17', 'X-MM-1',   'MM',   'A-102', 'Katolik',   'asrama'],
            ['25009', 'Indah Sari',       'P', 'Sragen',   '2010-12-03', 'X-MM-1',   'MM',   'A-102', 'Islam',     'orang_tua'],
            ['25010', 'Joko Susilo',      'L', 'Sragen',   '2010-06-09', 'X-MM-1',   'MM',   'A-102', 'Islam',     'orang_tua'],

            ['25011', 'Kartika Putri',    'P', 'Sragen',   '2009-05-25', 'XI-AKL-1', 'AKL',  'B-201', 'Islam',     'orang_tua'],
            ['25012', 'Lutfi Hakim',      'L', 'Sragen',   '2009-10-11', 'XI-AKL-1', 'AKL',  'B-201', 'Islam',     'kost'],
            ['25013', 'Maya Anggraini',   'P', 'Sragen',   '2009-03-28', 'XI-AKL-1', 'AKL',  'B-201', 'Islam',     'wali'],
            ['25014', 'Nanda Pratama',    'L', 'Sragen',   '2009-07-16', 'XI-AKL-1', 'AKL',  'B-201', 'Islam',     'orang_tua'],
            ['25015', 'Oktaviani Rahma',  'P', 'Sragen',   '2009-09-02', 'XI-AKL-1', 'AKL',  'B-201', 'Islam',     'orang_tua'],

            ['25016', 'Putra Mahardika',  'L', 'Sragen',   '2009-04-08', 'XI-OTKP-1','OTKP', 'B-202', 'Islam',     'orang_tua'],
            ['25017', 'Qori Hidayat',     'L', 'Sragen',   '2009-08-19', 'XI-OTKP-1','OTKP', 'B-202', 'Islam',     'asrama'],
            ['25018', 'Rina Marlina',     'P', 'Sragen',   '2009-11-27', 'XI-OTKP-1','OTKP', 'B-202', 'Islam',     'orang_tua'],
            ['25019', 'Surya Pranata',    'L', 'Sragen',   '2009-02-14', 'XI-OTKP-1','OTKP', 'B-202', 'Kristen',   'orang_tua'],
            ['25020', 'Tari Kusuma',      'P', 'Sragen',   '2009-06-23', 'XI-OTKP-1','OTKP', 'B-202', 'Islam',     'kost'],
        ];

        $namaAyah = ['Sutrisno', 'Bambang', 'Hartono', 'Suparman', 'Wijaya', 'Suryanto', 'Purnomo', 'Hadi', 'Jumadi', 'Karjo'];
        $namaIbu  = ['Sumiati', 'Partini', 'Sri Mulyani', 'Endang', 'Sutinem', 'Ratiyem', 'Kasmini', 'Poniyem', 'Tumiyem', 'Warniyah'];
        $pekerjaan = ['Petani', 'Wiraswasta', 'PNS', 'Karyawan Swasta', 'Buruh'];

        foreach ($siswaData as $i => $s) {
            [$nipd, $nama, $jk, $tmpLahir, $tglLahir, $kodeKelas, $kodeJurusan, $ruang, $agama, $jenisTinggal] = $s;

            if (DB::table('siswa')->where('nipd', $nipd)->exists()) continue;

            $tingkat = substr($kodeKelas, 0, 2);
            $sppNominal = $tingkat === '10' ? '250000' : '300000';
            $ayah = $namaAyah[$i % count($namaAyah)];
            $ibu  = $namaIbu[$i % count($namaIbu)];
            $pekerjaanAyah = $pekerjaan[$i % count($pekerjaan)];

            $id = DB::table('siswa')->insertGetId([
                'nipd'                  => $nipd,
                'password'              => Hash::make('siswa123'),
                'tanggal_masuk'         => '2025-07-15',
                'tahun_akademik'        => $tahunAktifId,
                'nisn'                  => '00' . $nipd . '88',
                'nama'                  => $nama,
                'jenis_kelamin'         => $jk,
                'nik'                   => '33140' . str_pad((string)(1000000 + $i), 8, '0', STR_PAD_LEFT),
                'tanggal_lahir'         => $tglLahir,
                'tempat_lahir'          => $tmpLahir,
                'agama'                 => $agama,
                'alamat'                => 'Jl. Raya Sragen No. ' . ($i + 1),
                'kebutuhan_khusus'      => 'Tidak Ada',
                'rt'                    => '0' . (($i % 5) + 1),
                'rw'                    => '0' . (($i % 3) + 1),
                'dusun'                 => 'Dusun ' . chr(65 + ($i % 5)),
                'kelurahan'             => 'Sonosari',
                'kecamatan'             => 'Karangmalang',
                'kode_pos'              => '57215',
                'jenis_tinggal'         => $jenisTinggal,
                'alat_transportasi'     => $i % 2 === 0 ? 'Sepeda Motor' : 'Sepeda',
                'telepon'               => '-',
                'hp'                    => '0812345' . str_pad((string)(1000 + $i), 4, '0', STR_PAD_LEFT),
                'email'                 => strtolower(str_replace(' ', '.', $nama)) . '@sabit.sch.id',
                'skhun'                 => 'SKHUN-' . $nipd,
                'penerima_kps'          => 'Tidak',
                'no_kps'                => '-',
                'foto'                  => null,
                'angkatan'              => '2025',
                'status_awal'           => 'baru',
                'status_siswa'          => 'aktif',
                'tingkat'               => $tingkat,
                'kode_kelas'            => $kodeKelas,
                'kode_jurusan'          => $kodeJurusan,
                'ruang'                 => $ruang,
                'spp_nominal'           => $sppNominal,
                'id_user'               => '1',
                'nama_ayah'             => $ayah,
                'tahun_lahir_ayah'      => (string)(1965 + ($i % 20)),
                'pendidikan_ayah'       => 'SMA/Sederajat',
                'pekerjaan_ayah'        => $pekerjaanAyah,
                'penghasilan_ayah'      => 'Rp 2.000.000 - Rp 4.000.000',
                'kebutuhan_khusus_ayah' => 'Tidak Ada',
                'no_telepon_ayah'       => '08123' . str_pad((string)(100000 + $i), 6, '0', STR_PAD_LEFT),
                'nama_ibu'              => $ibu,
                'tahun_lahir_ibu'       => (string)(1970 + ($i % 20)),
                'pendidikan_ibu'        => 'SMA/Sederajat',
                'pekerjaan_ibu'         => 'Ibu Rumah Tangga',
                'penghasilan_ibu'       => '-',
                'kebutuhan_khusus_ibu'  => 'Tidak Ada',
                'no_telepon_ibu'        => '08123' . str_pad((string)(200000 + $i), 6, '0', STR_PAD_LEFT),
                'nama_wali'             => '-',
                'tahun_lahir_wali'      => '-',
                'pendidikan_wali'       => '-',
                'pekerjaan_wali'        => '-',
                'penghasilan_wali'      => '-',
                'kebutuhan_khusus_wali' => '-',
                'no_telepon_wali'       => '-',
                'created_at'            => $now,
                'updated_at'            => $now,
            ]);

            DB::table('anggota_kelas')->insert([
                'id_siswa'       => $id,
                'tahun_akademik' => '2025/2026',
                'tingkat'        => $tingkat,
                'kode_kelas'     => $kodeKelas,
                'tgl_masuk'      => '2025-07-15',
                'tgl_keluar'     => '-',
                'status'         => 'aktif',
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}
