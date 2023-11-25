<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    //RELACIONES
    public function usuarios()
    {
        
        return $this->belongsToMany(User::class);
    }
}
