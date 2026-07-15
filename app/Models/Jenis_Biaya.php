<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_Biaya extends Model
{
    use HasFactory;
    protected $table = 'jenis_biaya';
    protected $guarded = ['id'];

    public function get_jenis_pembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class, 'id_jp');
    }
}
