<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = ['emisor','receptor', 'contenido'];

    //relaciones
    public function bibliografia()
    {
        $this->belongsTo(Bibliografia::class, 'bibliografia_id');
    }
}
