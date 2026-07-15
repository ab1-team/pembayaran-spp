<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun_akademik extends Model
{
    use HasFactory;
    protected $table = 'tahun_akademik';
    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'tahun_akademik', 'nama_tahun');
    }

    public function anggotaKelas()
    {
        return $this->hasMany(Anggota_Kelas::class, 'tahun_akademik', 'nama_tahun');
    }
}
