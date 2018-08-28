<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdenCompraRequest extends FormRequest
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
            'cotizacion_id' => 'required',
            'adminorden' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'direccion_entrega' => 'required',
        ];
    }

    public function messages()
    {
      return [
        'cotizacion_id.required' => 'La debe registrar una cotización',
        'adminorden.required' => 'Debe registrar un administrador para la orden de compra',
        'fecha_inicio.required' => 'Debe selecciona la fecha en que comenzará a recibir los materiales',
        'fecha_fin.required' => 'Debe selecciona la fecha de fin para recibir los materiales',
        'direccion_entrega.required' => 'Debe digitar la dirección de entrega',
      ];
    }
}
