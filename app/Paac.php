<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paac extends Model
{
    protected $guarded = [];
    protected $dates = [];
    public $incrementing = false;

    public function paacdetalle()
    {
        return $this->hasMany('App\Paacdetalle');
    }
}
