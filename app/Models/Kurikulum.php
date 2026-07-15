<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $table = 'kurikulum';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'kode_kurikulum', 'id');
    }

    public function kelasByName()
    {
        return $this->hasMany(Kelas::class, 'kode_kurikulum', 'nama_kurikulum');
    }
}
