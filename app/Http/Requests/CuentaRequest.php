<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuentaRequest extends FormRequest
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
            'numero_cuenta' => 'required|unique:cuentas',
            'banco_id' => 'required',
            'fecha_de_apertura' => 'required',
            'monto_inicial' => 'required|numeric',
        ];
    }
}
