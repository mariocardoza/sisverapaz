<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerpetuidadBeneficiario extends Model
{
    protected $guarded = [];
    protected $dates = ['fecha_entierro','fecha_exhumacion'];

    public function perpetuidad()
    {
        return $this->belongsTo('App\Perpetuidad');
    }
}
