<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pembayaran';

    protected $fillable = ['nama', 'kode_akun'];

    public const KODE_PIUTANG_DEFAULT = '1.1.03.01';

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'kode_akun', 'kode_akun');
    }

    public function isSpp(): bool
    {
        return stripos($this->nama, 'SPP') !== false;
    }

    public static function byKodeAkun(string $kodeAkun): ?self
    {
        return static::where('kode_akun', $kodeAkun)->first();
    }
}
