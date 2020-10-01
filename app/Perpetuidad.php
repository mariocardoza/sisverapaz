<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perpetuidad extends Model
{
    protected $guarded = [];

    public function cementerio()
    {
        return $this->belongsTo('App\Cementerio');
    }

    public function contribuyente()
    {
        return $this->belongsTo('App\Contribuyente');
    }

    public function beneficiarios()
    {
        return $this->hasMany('App\PerpetuidadBeneficiario','perpetuidad_id');
    }
}
