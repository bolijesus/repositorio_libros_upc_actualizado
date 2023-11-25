<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol1 =  Role::create([
             'nombre' => 'administrador',
             'descripcion' => 'Administrador del sistema'
         ]);
 
         $rol2 = Role::create([
             'nombre' => 'usuario',
             'descripcion' => 'Usuario general del sistema'
         ]);
         
         $usuario1 = User::create([
             'nombre'=>'jesus',
             'apellido'=>'bolivar',
             'usuario'=>'bolijesus98',
             'email'=>'bolijesus98@gmail.com',
             'verificado'=>true,
             'password'=>bcrypt('1234'),
             'direccion'=>'sicarare',
             'sexo'=>0
             ]);
         
 
        $usuario2 = User::create([
             'nombre'=>'carmen',
             'apellido'=>'castro',
             'usuario'=>'carmen98',
             'email'=>'carmen@gmail.com',
             'password'=>bcrypt('1234'),
             'direccion'=>'villacastro',
             'sexo'=>1
             ]);
         
             $usuario1->roles()->attach($rol1);
             $usuario2->roles()->attach($rol2);
     }
}
