<?php

namespace App\Http\Requests\Libro;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => 'required|max:100',
            'idioma' => 'required',
            'generos' => 'required',
            'autores' => 'required',
            'editorial' => 'required',
            'isbn' => 'required|numeric',
            '_archivo' => 'file',
            'descripcion' => 'required|max:200',
            '_portada' => 'image|dimensions:min_width=128,min_height=128',
            
        ];
    }
}
