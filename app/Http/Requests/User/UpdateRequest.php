<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'usuario' => 'required|unique:users,usuario,'.\request()->user->id.'|max:50',
            'email' => 'required|unique:users,email,'.\request()->user->id.'|max:50',
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'direccion' => 'required|max:75',
            'sexo' => 'required',
            '_foto_perfil' => 'image|dimensions:min_width=128,min_height=128',
        ];
    }

    public function messages(){
        return [
            'usuario.required' => 'Este campo es requerido',
            'usuario.unique' => 'Este Nombre de Usuario ya esta en uso',
            'usuario.max' => 'Este campo NO puede exceder los 50 caracteres',

            'email.required' => 'Este campo es requerido',
            'email.unique' => 'Este Email ya esta en uso',
            'email.max' => 'Este campo NO puede exceder los 50 caracteres',
            
            'nombre.required' => 'Este campo es requerido',
            'nombre.max' => 'Este campo NO puede exceder los 50 caracteres',

            'apellido.required' => 'Este campo es requerido',
            'apellido.max' => 'Este campo NO puede exceder los 50 caracteres',

            'direccion.required' => 'Este campo es requerido',
            'direccion.max' => 'Este campo NO puede exceder los 75 caracteres',

            'sexo.required' => 'Este campo es requerido',
            
            '_foto_perfil.dimensions' => 'Las dimensiones de la imagen deben ser minimo de 128x128',            
            '_foto_perfil.image' => 'Porfavor suba un archivo valido de imagen (jpeg,png...)',
        ];
    }
}
