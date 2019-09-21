<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudRequest extends FormRequest
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
            'formapago' => 'required',
            'cargo' => 'required',
        ];
    }

    public function messages()
    {
      return [
        'formapago.required' => 'Debe seleccionar la forma de pago',
        'unidad.required' => 'Debe seleccionar una unidad administrativa',
        'categoria.required' => 'Debe seleccionar una categoría del presupuesto',
        'fecha_limite.required' => 'Debe ingresar una fecha limite de entrega valida',
        'lugar_entrega.required' => 'Debe ingresar la dirección de entrega de la solicitud',
        'tiempo_entrega.required' => 'Debe ingresar el tiempo de entrega',
      ];
    }
}
