<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transaksi';
    protected $guarded = [];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'jumlah' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function spp()
    {
        return $this->belongsTo(Spp::class, 'spp_id');
    }

    public function rekeningDebit()
    {
        return $this->belongsTo(
            Rekening::class,
            'rekening_debit',
            'kode_akun'
        );
    }

    public function rekeningKredit()
    {
        return $this->belongsTo(
            Rekening::class,
            'rekening_kredit',
            'kode_akun'
        );
    }
}
