<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota_Kelas extends Model
{
    use HasFactory;
    protected $table = 'anggota_kelas';
    protected $guarded = ['id'];

    protected $casts = [
        'tgl_masuk' => 'date',
        'tgl_keluar' => 'date',
    ];

    public function tahunAkademik()
    {
        return $this->belongsTo(Tahun_Akademik::class, 'tahun_akademik', 'nama_tahun');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function spp()
    {
        return $this->hasMany(Spp::class, 'anggota_kelas', 'id');
    }

    public function getTahunAkademik()
    {
        return $this->tahunAkademik();
    }

    public function getKelas()
    {
        return $this->kelas();
    }

    public function getSiswa()
    {
        return $this->siswa();
    }

    public function getSpp()
    {
        return $this->spp();
    }
}
