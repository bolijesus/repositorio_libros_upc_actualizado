<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $fillable = ['vistas','descarga'];
    public function bibliografia()
    {
        return $this->belongsTo(Bibliografia::class,'bibliografia_id');
    }
}
