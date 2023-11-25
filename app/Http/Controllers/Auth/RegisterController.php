<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'usuario' => ['required','unique:users','max:50'],
            'email' => ['required','unique:users','max:50'],
            'password' => ['required','confirmed','max:50'],
            'nombre' => ['required','max:50'],
            'apellido' => ['required','max:50'],
            'direccion' => ['required','max:75'],
            'sexo' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'usuario' => $data['usuario'],
            'nombre' => $data['nombre'],
            'apellido' => $data['nombre'],
            'email' => $data['email'],
            'direccion' => $data['direccion'],
            'sexo' => $data['sexo'],
            'password' => Hash::make($data['password']),
        ]);
        $user->roles()->attach(2);

        \notificarAdministradores($user,'Nuevo Usuario registrado, verifiquelo.','accessibility','bg-cyan');
        return $user;
    }
}
