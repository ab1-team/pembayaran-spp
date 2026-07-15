<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;
    protected $table = 'rekening';
    protected $guarded = [];

    protected $casts = [
        'saldo' => 'decimal:2',
        'tgl_nonaktif' => 'date',
    ];

    public function akunLevel3()
    {
        return $this->belongsTo(AkunLevel3::class, 'parent_id');
    }

    public function transaksiDebit()
    {
        return $this->hasMany(Transaksi::class, 'rekening_debit', 'kode_akun');
    }

    public function transaksiKredit()
    {
        return $this->hasMany(Transaksi::class, 'rekening_kredit', 'kode_akun');
    }
}
