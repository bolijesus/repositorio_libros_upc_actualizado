<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password', 'apellido', 'usuario', 'sexo' , 'direccion', 
        'puntos_descarga','foto_perfil', 'verificado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //RELACIONES
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function bibliografias()
    {
        return $this->hasMany(Bibliografia::class);
    }

    //FUNCIONES
    public function isAdmin()
    {
        return $this->hasRole('administrador') ? true : false;
    }
    
    public function hasRole($id)
    {
        foreach ($this->roles as $rolUser) {
            if ($id == $rolUser->id || $id == $rolUser->nombre) {
                return true;
            }
        }
        return false;        
    }
}
