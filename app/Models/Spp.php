<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    use HasFactory;
    protected $table = 'spp';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'spp_id');
    }

    public function anggotaKelas()
    {
        return $this->belongsTo(Anggota_Kelas::class, 'anggota_kelas', 'id');
    }

    public function getAnggotaKelas()
    {
        return $this->anggotaKelas();
    }
}
