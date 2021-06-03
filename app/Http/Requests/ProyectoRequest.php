<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoRequest extends FormRequest
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
            'nombre' => 'required|min:3|max:150',
            'monto' => 'required|numeric|min:1',
            'direccion' => 'required|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'motivo' => 'required',
            'monto_desarrollo' => 'required',
        ];
    }
}
