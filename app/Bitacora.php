<?php

namespace App;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Events\BitacoraSaved;

class Bitacora extends Model
{
    protected $guarded = [];
    protected $dates = ['registro'];

    protected $events = [
        'saved'=>BitacoraSaved::class,
    ];

    public static function bitacora($accion)
    {
        $bitacora = new Bitacora;
        $bitacora->registro = date('Y-m-d');
        $bitacora->hora = date('H:i:s');
        $bitacora->accion = $accion;
        $bitacora->user_id = Auth()->user()->id;
        $bitacora->save();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
