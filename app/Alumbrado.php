<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumbrado extends Model
{
    protected $guarded=[];
    protected $dates=['fecha','fecha_reparacion'];

    public function bitacora()
    {
        return $this->hasMany('App\Bitacora_alumbrado','alumbrado_id')->orderby('created_at');
    }
}
