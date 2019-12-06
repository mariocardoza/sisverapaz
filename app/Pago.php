<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable=['tipopago_id','cuenta_id','num_factura','contribuyente_id', 'monto'];
    // protected $guarded = [];

    // public function contribuyente()
    // {
    //     return $this->belongsTo('App\Contribuyente');
    // }
    public function tipopago()
   {
       return $this->belongsTo('App\Tipopago');
    }
}
