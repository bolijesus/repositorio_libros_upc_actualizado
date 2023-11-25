<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revista extends Model
{
    protected $fillable = ['publicador'];

    //RELACIONES
    public function bibliografia()
    {
        return $this->morphOne(Bibliografia::class, 'bibliografiable');
    }
}
