<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
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
            'nombre'=>'required|min:3|max:150',
            'dui'=>'required|numeric',
            'nit'=>'required|numeric',
            'direccion'=>'required|max:255',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date',
        ];
    }
}