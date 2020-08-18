<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuestodetalle extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function presupuesto()
    {
      return $this->belongsTo('App\Presupuesto');
    }

    

    public function material()
    {
      return $this->belongsTo('App\Materiales','material_id')->orderBy('categoria_id','ASC');
    }

    public function unidadmedida()
      {
        return $this->belongsTo('App\UnidadMedida','unidad_medida')->withDefault();
      }
    
}
