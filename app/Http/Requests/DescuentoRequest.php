<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescuentoRequest extends FormRequest
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
            'empleado_id' => 'required',
            'cuota' => 'required',
           
            'categoriadescuento_id' => 'required',
            'fecha_inicio' => 'required',
        ];
    }

    public function messages()
     {
         return [
         'empleado_id.required'=>'El campo empleado es obligatorio',
         'cuota.required'=>'El campo cuota es obligatoria',
         'categoriadescuento_id.required'=>'La categoría es obligatoria',
         'fecha_inicio.required'=>'La fecha de inicio es obligatoria',
         ];
     }
}
