<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora_alumbrado extends Model
{
    protected $guarded =[];
    protected $dates=['fecha'];

    public function alumbrado()
    {
        return $this->belongsTo('App\Alumbrado');
    }
}
