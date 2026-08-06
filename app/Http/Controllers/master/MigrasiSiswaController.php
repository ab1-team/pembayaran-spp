<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MigrasiSiswaController extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademiks = DB::table('tahun_akademik')
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();

        $jurusan = DB::table('jurusan')
            ->orderBy('nama')
            ->get(['id', 'nama', 'kode_jurusan']);

        $selectedTahun = $request->query('tahun_akademik_id');
        $selectedJurusan = $request->query('jurusan_id');

        $kelas = collect();
        if ($selectedTahun) {
            $kelas = DB::table('kelas')
                ->where('tahun_akademik_id', $selectedTahun)
                ->when($selectedJurusan, fn ($q) => $q->where('jurusan_id', $selectedJurusan))
                ->orderBy('nama_kelas')
                ->get(['id', 'nama_kelas', 'tingkat']);
        }

        if ($request->isMethod('post')) {
            return response()->json([
                'ok' => true,
                'message' => 'File diterima. Fitur import Excel sedang dalam pengembangan.',
            ]);
        }

        $excelColumns = [
            ['key' => 'nik',          'label' => 'NIK',                  'required' => true,  'example' => '3501234567890001'],
            ['key' => 'nama',         'label' => 'Nama Lengkap',         'required' => true,  'example' => 'Ahmad Fauzi'],
            ['key' => 'jenis_kelamin','label' => 'Jenis Kelamin',        'required' => true,  'example' => 'L / P'],
            ['key' => 'nipd',         'label' => 'NIS',                  'required' => true,  'example' => '2026001'],
            ['key' => 'nisn',         'label' => 'NISN',                 'required' => true,  'example' => '0091234567'],
            ['key' => 'no_kk',        'label' => 'No. KK',               'required' => true,  'example' => '3501234567890002'],
            ['key' => 'tempat_lahir', 'label' => 'Tempat Lahir',         'required' => true,  'example' => 'Surabaya'],
            ['key' => 'tanggal_lahir','label' => 'Tanggal Lahir',        'required' => true,  'example' => '2010-05-12'],
            ['key' => 'agama',        'label' => 'Agama',                'required' => true,  'example' => 'Islam'],
            ['key' => 'password',     'label' => 'Password Default',     'required' => false, 'example' => '123456'],
            ['key' => 'alamat',       'label' => 'Alamat',               'required' => true,  'example' => 'Jl. Merdeka No.10'],
            ['key' => 'rt',           'label' => 'RT',                   'required' => false, 'example' => '001'],
            ['key' => 'rw',           'label' => 'RW',                   'required' => false, 'example' => '002'],
            ['key' => 'dusun',        'label' => 'Dusun',                'required' => false, 'example' => 'Dusun Krajan'],
            ['key' => 'kelurahan',    'label' => 'Kelurahan',            'required' => false, 'example' => 'Sukamaju'],
            ['key' => 'kecamatan',    'label' => 'Kecamatan',            'required' => false, 'example' => 'Sukorejo'],
            ['key' => 'kode_pos',     'label' => 'Kode Pos',             'required' => false, 'example' => '60123'],
            ['key' => 'kebutuhan_khusus','label' => 'Kebutuhan Khusus',  'required' => false, 'example' => 'Tidak'],
            ['key' => 'jenis_tinggal','label' => 'Jenis Tinggal',        'required' => false, 'example' => 'orang_tua / asrama / kost / wali'],
            ['key' => 'alat_transportasi','label' => 'Alat Transportasi','required' => false, 'example' => 'Sepeda Motor'],
            ['key' => 'hp',           'label' => 'No. HP Siswa',         'required' => false, 'example' => '081234567890'],
            ['key' => 'email',        'label' => 'Email',                'required' => false, 'example' => 'siswa@mail.com'],
            ['key' => 'nama_ayah',    'label' => 'Nama Ayah',            'required' => true,  'example' => 'Budi Santoso'],
            ['key' => 'tahun_lahir_ayah','label' => 'Tahun Lahir Ayah',  'required' => false, 'example' => '1980'],
            ['key' => 'pendidikan_ayah','label' => 'Pendidikan Ayah',    'required' => false, 'example' => 'SMA'],
            ['key' => 'pekerjaan_ayah','label' => 'Pekerjaan Ayah',      'required' => false, 'example' => 'Wiraswasta'],
            ['key' => 'penghasilan_ayah','label' => 'Penghasilan Ayah',  'required' => false, 'example' => '3000000'],
            ['key' => 'no_telepon_ayah','label' => 'No. Telp Ayah',      'required' => false, 'example' => '081234567891'],
            ['key' => 'nama_ibu',     'label' => 'Nama Ibu',             'required' => true,  'example' => 'Siti Aminah'],
            ['key' => 'tahun_lahir_ibu','label' => 'Tahun Lahir Ibu',    'required' => false, 'example' => '1982'],
            ['key' => 'pendidikan_ibu','label' => 'Pendidikan Ibu',      'required' => false, 'example' => 'SMA'],
            ['key' => 'pekerjaan_ibu','label' => 'Pekerjaan Ibu',        'required' => false, 'example' => 'Ibu Rumah Tangga'],
            ['key' => 'penghasilan_ibu','label' => 'Penghasilan Ibu',    'required' => false, 'example' => '0'],
            ['key' => 'no_telepon_ibu','label' => 'No. Telp Ibu',        'required' => false, 'example' => '081234567892'],
            ['key' => 'kode_kelas',   'label' => 'Kode Kelas',           'required' => true,  'example' => 'X-TKJ-1'],
            ['key' => 'ruang',        'label' => 'Ruang',                'required' => false, 'example' => 'R-101'],
            ['key' => 'tingkat',      'label' => 'Tingkat',              'required' => false, 'example' => '10'],
        ];

        return view('master.migrasi-siswa', [
            'tahunAkademiks' => $tahunAkademiks,
            'jurusan' => $jurusan,
            'kelas' => $kelas,
            'selectedTahun' => $selectedTahun,
            'selectedJurusan' => $selectedJurusan,
            'excelColumns' => $excelColumns,
        ]);
    }

    public function template(Request $request)
    {
        return response()->json([
            'ok' => true,
            'message' => 'Template akan tersedia segera.',
        ]);
    }
}
