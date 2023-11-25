<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Genero extends Model
{
    protected $fillable=['nombre', 'descripcion'];
    
    //RELACIONES
    public function bibliografias()
    {
        return $this->belongsToMany(Bibliografia::class);
    }
}
