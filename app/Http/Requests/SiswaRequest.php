<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        // Semua teks boleh "-" / "0" / kosong → service normalisasi ke null.
        // Wajib hanya untuk field yang memang harus ada isinya.
        $optional = 'nullable|string|max:255';

        $base = [
            // Wajib (inti data siswa) — sisanya boleh "-" / "0" / kosong
            'nisn'                  => 'required|string|max:20',
            'nama'                  => 'required|string|max:255',
            'jenis_kelamin'         => 'required|in:L,P',
            'tempat_lahir'          => 'required|string|max:100',
            'tanggal_lahir'         => 'required|date',
            'agama'                 => 'required|string|max:50',
            'status_awal'           => 'required|in:baru,pindahan',
            'status_siswa'          => 'required|in:aktif,nonaktif,blokir',
            'tanggal_masuk'         => 'required|date',
            'kelas'                 => 'required|string',
            'ruangan'               => 'required|string|max:50',
            'tahun_akademik'        => 'required|string|max:20',

            // Opsional (boleh "-")
            'nipd'                  => $optional,
            'no_kk'                 => 'nullable|string|max:16',
            'nik'                   => $optional,
            'kecamatan'             => $optional,
            'kelurahan'             => $optional,
            'dusun'                 => $optional,
            'rt'                    => 'nullable|string|max:5',
            'rw'                    => 'nullable|string|max:5',
            'alamat'                => $optional,
            'kode_pos'              => 'nullable|string|max:10',
            'kebutuhan_khusus'      => $optional,
            'jenis_tinggal'         => 'nullable|in:orang_tua,asrama,kost,wali',
            'transportasi'          => $optional,
            'hp'                    => $optional,
            'email'                 => 'nullable|email|max:255',
            'skhun'                 => $optional,
            'penerima_kps'          => $optional,
            'no_kps'                => 'nullable|string|max:50',
            'spp_nominal'           => 'nullable|string|max:30',

            // Wali (semua opsional)
            'nama_ayah'             => $optional,
            'tahun_lahir_ayah'      => 'nullable|string|max:10',
            'pendidikan_ayah'       => $optional,
            'pekerjaan_ayah'        => $optional,
            'penghasilan_ayah'      => 'nullable|string|max:50',
            'kebutuhan_khusus_ayah' => $optional,
            'no_telp_ayah'          => $optional,
            'nama_ibu'              => $optional,
            'tahun_lahir_ibu'       => 'nullable|string|max:10',
            'pendidikan_ibu'        => $optional,
            'pekerjaan_ibu'         => $optional,
            'penghasilan_ibu'       => 'nullable|string|max:50',
            'kebutuhan_khusus_ibu'  => $optional,
            'no_telp_ibu'           => $optional,
            'nama_wali'             => 'nullable|string|max:255',
            'tahun_lahir_wali'      => 'nullable|string|max:10',
            'pendidikan_wali'       => 'nullable|string|max:100',
            'pekerjaan_wali'        => 'nullable|string|max:100',
            'penghasilan_wali'      => 'nullable|string|max:50',
            'kebutuhan_khusus_wali' => 'nullable|string|max:100',
            'no_telp_wali'          => 'nullable|string|max:20',

            'foto'                  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $base['password'] = $isUpdate
            ? 'nullable|min:6'
            : 'required|string|min:6';

        return $base;
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'in'       => ':attribute tidak valid.',
            'email'    => 'Format :attribute tidak valid.',
            'date'     => 'Format :attribute harus tanggal (YYYY-MM-DD).',
            'image'    => ':attribute harus file gambar.',
            'mimes'    => ':attribute harus jpeg/png/jpg.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nisn' => 'NISN',
            'nama' => 'Nama Lengkap',
            'tanggal_lahir' => 'Tanggal Lahir',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_masuk' => 'Tanggal Masuk',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tahun_akademik' => 'Tahun Akademik',
            'kelas' => 'Kelas',
            'ruangan' => 'Ruangan',
            'password' => 'Password',
        ];
    }
}