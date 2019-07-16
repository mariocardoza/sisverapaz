<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inmueble extends Model
{
    protected $guarded = [];
    protected $fillable = ['estado'];
    
    public function contribuyente()
    {
    	return $this->belongsTo('App\Contribuyente');
    }
    
    public function tipoServicio()
    {
        return $this->belongsToMany('App\TipoServicio')->withTimestamps();
    }
}
