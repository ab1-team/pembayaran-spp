<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $table = 'saldo';
    protected $guarded = ['id'];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
        'debit' => 'decimal:2',
        'kredit' => 'decimal:2',
    ];

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'kode_akun', 'kode_akun');
    }
}
