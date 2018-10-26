<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleplanillaRequest extends FormRequest
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
             'salario' => 'required',
             'tipo_pago' => 'required',
             'pago' => 'required',
         ];
     }

     public function messages()
     {
         return [
         'empleado_id.required'=>'El campo empleado es obligatorio',
         'salario.required'=>'El campo salario es obligatorio',
         'tipo_pago.required'=>'El campo forma de pago es obligatorio',
         'pago.required'=>'El campo tiempo de pago es obligatorio',
         ];
     }
}
