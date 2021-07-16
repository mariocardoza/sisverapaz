<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NegocioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre'              =>'required|min:3|max:50',
            'rubro_id'            =>'required',
            'contribuyente_id'    =>'required',
            'direccion'           =>'required|min:10|max:70',
        ];
    }

    public function messages()
    {
        return [
        'rubro_id.required'=>'El campo rubro es obligatorio',
        ];
    }
}
