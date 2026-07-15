<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanda_tangan extends Model
{
    use HasFactory;
    protected $table = 'tanda_tangan';
    protected $guarded = ['id'];

    public function getTandaTanganAttribute($value)
    {
        return stripslashes($value);
    }

    public function setTandaTanganAttribute($value)
    {
        $this->attributes['tanda_tangan'] = addslashes($value);
    }
}
