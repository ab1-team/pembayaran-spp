<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun_Akademik extends Model
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

    /**
     * Tahun akademik yang sedang berjalan (tahun ajaran dimulai bulan Juli).
     * Jika belum terdaftar, ambil tahun akademik terbaru.
     */
    public static function berjalan(): ?string
    {
        $now = \Carbon\Carbon::now();
        $yy  = (int) $now->format('Y');
        $mm  = (int) $now->format('n');

        $candidate = $mm >= 7
            ? sprintf('%d/%d', $yy, $yy + 1)
            : sprintf('%d/%d', $yy - 1, $yy);

        return static::where('nama_tahun', $candidate)->value('nama_tahun')
            ?? static::orderByDesc('nama_tahun')->value('nama_tahun');
    }
}
