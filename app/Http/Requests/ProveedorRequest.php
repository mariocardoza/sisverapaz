<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string',
            'telefono' => 'required|min:9',
            'email' => 'required|string|email',
            'numero_registro' => 'required',
            'nit' => 'required|min:17',
        ];
    }
}
