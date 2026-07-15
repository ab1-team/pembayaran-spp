<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLaporan extends Model
{
    use HasFactory;
    protected $table = 'sub_laporans';
    protected $guarded = ['id'];

    public function jenisLaporan()
    {
        return $this->belongsTo(JenisLaporan::class, 'id_lap', 'id');
    }
}
