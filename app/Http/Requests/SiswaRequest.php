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
        $siswaId = $this->route('siswa')?->id;

        $base = [
            'nipd'                  => 'required',
            'nisn'                  => 'required',
            'nik'                   => 'required',
            'nama'                  => 'required',
            'tempat_lahir'          => 'required',
            'tanggal_lahir'         => 'required|date',
            'jenis_kelamin'         => 'required|in:L,P',
            'agama'                 => 'required',
            'kecamatan'             => 'required',
            'kelurahan'             => 'required',
            'dusun'                 => 'required',
            'rt'                    => 'required',
            'rw'                    => 'required',
            'alamat'                => 'required',
            'kode_pos'              => 'required',
            'status_awal'           => 'required|in:baru,pindahan',
            'status_siswa'          => 'required|in:aktif,nonaktif,blokir',
            'tanggal_masuk'         => 'required|date',
            'kebutuhan_khusus'      => 'required',
            'jenis_tinggal'         => 'required|in:orang_tua,asrama,kost,wali',
            'transportasi'          => 'required',
            'hp'                    => 'required',
            'kelas'                 => 'required',
            'jurusan'               => 'required',
            'ruangan'               => 'required',
            'email'                 => 'required|email',
            'tahun_akademik'        => 'required',
            'angkatan'              => 'required',
            'skhun'                 => 'required',
            'penerima_kps'          => 'required',
            'no_kps'                => 'nullable',
            'spp_nominal'           => 'required',
            'nama_ayah'             => 'required',
            'tahun_lahir_ayah'      => 'required',
            'pendidikan_ayah'       => 'required',
            'pekerjaan_ayah'        => 'required',
            'penghasilan_ayah'      => 'required',
            'kebutuhan_khusus_ayah' => 'required',
            'no_telp_ayah'          => 'required',
            'nama_ibu'              => 'required',
            'tahun_lahir_ibu'       => 'required',
            'pendidikan_ibu'        => 'required',
            'pekerjaan_ibu'         => 'required',
            'penghasilan_ibu'       => 'required',
            'kebutuhan_khusus_ibu'  => 'required',
            'no_telp_ibu'           => 'required',
            'nama_wali'             => 'nullable',
            'tahun_lahir_wali'      => 'nullable',
            'pendidikan_wali'       => 'nullable',
            'pekerjaan_wali'        => 'nullable',
            'penghasilan_wali'      => 'nullable',
            'kebutuhan_khusus_wali' => 'nullable',
            'no_telp_wali'          => 'nullable',
            'foto'                  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $base['password'] = $isUpdate
            ? 'nullable|min:6'
            : 'required|min:6';

        return $base;
    }
}
