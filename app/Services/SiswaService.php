<?php

namespace App\Services;

use App\Models\Anggota_Kelas;
use App\Models\Siswa;
use App\Models\Spp;
use Carbon\Carbon;

class SiswaService
{
    public function createWithKelasDanSpp(array $data): Siswa
    {
        [$kodeKelas, $tingkat] = $this->splitKelas($data['kelas']);
        $nominal = $this->normalizeNominal($data['spp_nominal'] ?? $data['alokasi_spp'] ?? 0);

        $siswa = Siswa::create([
            'nipd'                  => $data['nipd'],
            'password'              => $data['password'],
            'nisn'                  => $data['nisn'],
            'nik'                   => $data['nik'],
            'email'                 => $data['email'],
            'tahun_akademik'        => $data['tahun_akademik'],
            'tanggal_masuk'         => $data['tanggal_masuk'],
            'tingkat'               => $tingkat,
            'ruang'                 => $data['ruangan'],
            'id_user'               => auth()->id(),
            'nama'                  => $data['nama'],
            'tempat_lahir'          => $data['tempat_lahir'],
            'tanggal_lahir'         => $data['tanggal_lahir'],
            'jenis_kelamin'         => $data['jenis_kelamin'],
            'agama'                 => $data['agama'],
            'kecamatan'             => $data['kecamatan'],
            'kelurahan'             => $data['kelurahan'],
            'dusun'                 => $data['dusun'],
            'rt'                    => $data['rt'],
            'rw'                    => $data['rw'],
            'alamat'                => $data['alamat'],
            'kode_pos'              => $data['kode_pos'],
            'status_awal'           => $data['status_awal'],
            'status_siswa'          => $data['status_siswa'],
            'foto'                  => $data['foto'] ?? 'default.png',
            'kebutuhan_khusus'      => $data['kebutuhan_khusus'],
            'jenis_tinggal'         => $data['jenis_tinggal'],
            'alat_transportasi'     => $data['transportasi'],
            'hp'                    => $data['hp'],
            'kode_kelas'            => $kodeKelas,
            'kode_jurusan'          => $data['jurusan'],
            'angkatan'              => $data['angkatan'],
            'skhun'                 => $data['skhun'],
            'penerima_kps'          => $data['penerima_kps'],
            'no_kps'                => $data['no_kps'] ?? null,
            'spp_nominal'           => (string) $nominal,
            'nama_ayah'             => $data['nama_ayah'],
            'tahun_lahir_ayah'      => $data['tahun_lahir_ayah'],
            'pendidikan_ayah'       => $data['pendidikan_ayah'],
            'pekerjaan_ayah'        => $data['pekerjaan_ayah'],
            'penghasilan_ayah'      => $data['penghasilan_ayah'],
            'kebutuhan_khusus_ayah' => $data['kebutuhan_khusus_ayah'],
            'no_telepon_ayah'       => $data['no_telp_ayah'],
            'nama_ibu'              => $data['nama_ibu'],
            'tahun_lahir_ibu'       => $data['tahun_lahir_ibu'],
            'pendidikan_ibu'        => $data['pendidikan_ibu'],
            'pekerjaan_ibu'         => $data['pekerjaan_ibu'],
            'penghasilan_ibu'       => $data['penghasilan_ibu'],
            'kebutuhan_khusus_ibu'  => $data['kebutuhan_khusus_ibu'],
            'no_telepon_ibu'        => $data['no_telp_ibu'],
            'nama_wali'             => $data['nama_wali'] ?? null,
            'tahun_lahir_wali'      => $data['tahun_lahir_wali'] ?? null,
            'pendidikan_wali'       => $data['pendidikan_wali'] ?? null,
            'pekerjaan_wali'        => $data['pekerjaan_wali'] ?? null,
            'penghasilan_wali'      => $data['penghasilan_wali'] ?? null,
            'kebutuhan_khusus_wali' => $data['kebutuhan_khusus_wali'] ?? null,
            'no_telepon_wali'       => $data['no_telp_wali'] ?? null,
        ]);

        $anggota = $this->attachKelas($siswa, $kodeKelas, $tingkat, $data);
        $this->generateSppBulanan($anggota, $nominal, $data);

        return $siswa;
    }

    public function attachKelas(Siswa $siswa, string $kodeKelas, string $tingkat, array $data): Anggota_Kelas
    {
        return Anggota_Kelas::create([
            'id_siswa'       => $siswa->id,
            'tahun_akademik' => $this->resolveTahunAkademikNama($data),
            'tingkat'        => $tingkat,
            'kode_kelas'     => $kodeKelas,
            'tgl_masuk'      => $data['tanggal_masuk'],
            'tgl_keluar'     => Carbon::parse($data['tanggal_masuk'])->addYear()->format('Y-m-d'),
            'status'         => 'aktif',
        ]);
    }

    public function generateSppBulanan(Anggota_Kelas $anggota, int $nominal, array $data): void
    {
        $tahunMasuk = Carbon::parse($data['tanggal_masuk'])->year;
        $mulai = Carbon::create($tahunMasuk, 7, 1);
        $akhir = $mulai->copy()->addYear()->subDay();

        while ($mulai->lte($akhir)) {
            Spp::create([
                'tanggal'       => $mulai->format('Y-m-d'),
                'anggota_kelas' => $anggota->id,
                'nominal'       => (string) $nominal,
            ]);
            $mulai->addMonth();
        }
    }

    public function splitKelas(string $kelas): array
    {
        return explode('-', $kelas) + [null, null];
    }

    public function normalizeNominal($value): int
    {
        return (int) str_replace(['.', ','], '', (string) $value);
    }

    public function resolveTahunAkademikNama(array $data): string
    {
        if (is_numeric($data['tahun_akademik'])) {
            $ta = \App\Models\Tahun_akademik::find($data['tahun_akademik']);
            if ($ta) {
                return $ta->nama_tahun;
            }
        }
        return (string) $data['tahun_akademik'];
    }
}
