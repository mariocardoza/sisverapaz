<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Cuenta;

class OnlyAccountByYear implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $tipo_cuenta;
    public function __construct($tipo_cuenta)
    {
        $this->tipo_cuenta = $tipo_cuenta;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tipo = Cuenta::where('anio',date('Y'))->where('tipo_cuenta',$value)->first();
        if($tipo){
            $eltipo= $tipo->tipo_cuenta;
            if($eltipo!=3){
                return $eltipo!=$value;
            }else{
                return true;
            }
        }else{
            return true;
        }
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Solo se permite una cuenta de este tipo por año.';
    }
}
