<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pembayaran';

    protected $fillable = ['nama', 'kode_akun', 'is_spp'];

    protected $casts = ['is_spp' => 'boolean'];
}
