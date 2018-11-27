<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestamoRequest extends FormRequest
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
            'empleado_id'=>'required',
            'banco_id'=>'required',
            'numero_de_cuenta'=>'required',
            'monto'=>'required',
            'numero_de_cuotas'=>'required',
            'cuota'=>'required'
        ];
    }
}
