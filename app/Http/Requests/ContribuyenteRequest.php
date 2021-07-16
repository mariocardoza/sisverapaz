<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContribuyenteRequest extends FormRequest
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
            'nombre' => 'required|min:3|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ]*)*)+$/|max:255',
            'dui' => 'nullable|max:10',
            'nit' => 'nullable',
            'direccion' => 'required|max:100',
            'telefono' => 'nullable',
            'sexo' => 'required',
            'nacimiento' => 'nullable',
        ];
    }
}
