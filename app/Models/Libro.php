<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $fillable =['editorial','isbn'];

    //RELACIONES
    public function bibliografia()
    {
        return $this->morphOne(Bibliografia::class, 'bibliografiable');
    }

}
