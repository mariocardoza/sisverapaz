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
            'dui'=>'required|unique:empleados|min:10',
            'nit'=>'required|unique:empleados|min:17',
            'email'=>'required|email|unique:empleados',
            'direccion'=>'required|max:190',
            //'departamento' => 'required',
            //'municipio' => 'required',
            'fecha_nacimiento' => 'required|date',
            'sexo'=>'required',
            'celular' => 'required|min:9|unique:empleados',
        ];
    }
}
