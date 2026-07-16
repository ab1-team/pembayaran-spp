<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncKelasAnggotaFromSiswa extends Seeder
{
    public function run(): void
    {
        $now = now();
        $tingkatOf = static function (string $kode): string {
            if ($kode === 'AL') return 'AL';
            foreach (['XII','XI','X','IX','VIII','VII','VI','V','IV','III','II','I'] as $p) {
                if (str_starts_with($kode, $p) && (strlen($kode) === strlen($p) || !ctype_alpha($kode[strlen($p)]))) return $p;
            }
            return $kode;
        };

        foreach (DB::table('siswa')->select('tahun_akademik')->distinct()->pluck('tahun_akademik') as $nama) {
            [$y1] = explode('/', $nama);
            DB::table('tahun_akademik')->updateOrInsert(
                ['nama_tahun' => $nama],
                [
                    'keterangan' => 'Ganjil/Genap',
                    'status'     => ((int) $y1 === (int) date('Y')) ? 'aktif' : 'nonaktif',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $kurikulum = DB::table('kurikulum')->value('kode_kurikulum') ?? 'K-MERDEKA';
        foreach (DB::table('siswa')->select('kode_kelas')->distinct()->pluck('kode_kelas') as $kode) {
            DB::table('kelas')->updateOrInsert(
                ['kode_kelas' => $kode],
                ['nama_kelas' => $kode, 'tingkat' => $tingkatOf($kode), 'kode_kurikulum' => $kurikulum, 'updated_at' => $now, 'created_at' => $now]
            );
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('anggota_kelas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $batch = []; $i = 0;
        $rows = DB::table('siswa')->select('id', 'kode_kelas', 'tahun_akademik', 'tgl_masuk')->orderBy('id')->cursor();
        foreach ($rows as $s) {
            $isAlumni = $s->kode_kelas === 'AL';
            $batch[] = [
                'id_siswa'       => $s->id,
                'tahun_akademik' => $s->tahun_akademik,
                'tingkat'        => $tingkatOf($s->kode_kelas),
                'kode_kelas'     => $s->kode_kelas,
                'tgl_masuk'      => $s->tgl_masuk,
                'tgl_keluar'     => $isAlumni ? $s->tgl_masuk : '-',
                'status'         => $isAlumni ? 'nonaktif' : 'aktif',
                'created_at'     => $now, 'updated_at' => $now,
            ];
            if (++$i % 500 === 0) { DB::table('anggota_kelas')->insert($batch); $batch = []; }
        }
        if ($batch) DB::table('anggota_kelas')->insert($batch);

        foreach (DB::table('siswa')->where('tahun_akademik', 'like', '%/%')->get(['id', 'tahun_akademik']) as $s) {
            $y = (int) explode('/', $s->tahun_akademik)[0];
            DB::table('siswa')->where('id', $s->id)->update(['tgl_masuk' => sprintf('%d-07-15', $y)]);
        }
    }
}
