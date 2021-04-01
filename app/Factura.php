<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $guarded = [];
    protected $dates=['fechaVencimiento'];

    public function items()
    {
        return $this->hasMany('App\FacturasItems');
    }

    public function inmueble()
    {
        return $this->belongsTo('App\Inmueble','mueble_id');
    }
    public static function basico($numero) {
        $valor = array ('uno','dos','tres','cuatro','cinco','seis','siete',
        'ocho','nueve','diez','once','doce','trece','catorce','quince','dieciséis','diecisiete',
        'dieciocho','diecinueve','veinte','veintiuno','veintidos','veintitrés','veinticuatro',
        'veinticinco','veintiséis','veintisiete','veintiocho','veintinueve');
        return $valor[$numero - 1];
        }
        
        public static function decenas($n) {
        $decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
        70=>'setenta',80=>'ochenta',90=>'noventa');
        if( $n <= 29) return Factura::basico($n);
        $x = $n % 10;
        if ( $x == 0 ) {
        return $decenas[$n];
        } else return $decenas[$n - $x].' y '. Factura::basico($x);
        }
        
        public static function centenas($n) {
        $cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
        400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
        700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
        if( $n >= 100) {
        if ( $n % 100 == 0 ) {
        return $cientos[$n];
        } else {
        $u = (int) substr($n,0,1);
        $d = (int) substr($n,1,2);
        return (($u == 1)?'ciento':$cientos[$u*100]).' '.Factura::decenas($d);
        }
        } else return Factura::decenas($n);
        }
        
        public static function miles($n) {
        if($n > 999) {
        if( $n == 1000) {return 'mil';}
        else {
        $l = strlen($n);
        $c = (int)substr($n,0,$l-3);
        $x = (int)substr($n,-3);
        if($c == 1) {$cadena = 'mil '.Factura::centenas($x);}
        else if($x != 0) {$cadena = Factura::centenas($c).' mil '.Factura::centenas($x);}
        else $cadena = Factura::centenas($c). ' mil';
        return $cadena;
        }
        } else return Factura::centenas($n);
        }
        
        public static function millones($n) {
        if($n == 1000000) {return 'un millón';}
        else {
        $l = strlen($n);
        $c = (int)substr($n,0,$l-6);
        $x = (int)substr($n,-6);
        if($c == 1) {
        $cadena = ' millón ';
        } else {
        $cadena = ' millones ';
        }
        return Factura::miles($c).$cadena.(($x > 0)?Factura::miles($x):'');
        }
        }
        public static function convertir($n) {
        switch (true) {
        case ( $n >= 1 && $n <= 29) : return Factura::basico($n); break;
        case ( $n >= 30 && $n < 100) : return Factura::decenas($n); break;
        case ( $n >= 100 && $n < 1000) : return Factura::centenas($n); break;
        case ($n >= 1000 && $n <= 999999): return Factura::miles($n); break;
        case ($n >= 1000000): return millones($n);
        }
        }
        public static function personal($buscar){
            if($role_id=Role::where('name',$buscar)->count()>0){

                $role_id=Role::where('name',$buscar)->get()->first()->id;
                $role_users=RoleUser::where('role_id',$role_id)->get();
                foreach($role_users as $rl){
                    if($rl->user->estado){
                        return $rl->user->username;
                    }
                }
                return "-----";
            }else{
                return "-----";
            }
        }
}