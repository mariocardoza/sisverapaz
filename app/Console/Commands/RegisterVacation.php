<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Detalleplanilla;
use App\Vacacion;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RegisterVacation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registered:vacations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener próximas vacaciones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info(Carbon::now());
        $empleados=DB::table('empleados')
        ->select('empleados.*','detalleplanillas.fecha_inicio','detalleplanillas.id as elid')
        ->join('detalleplanillas','empleados.id','=','detalleplanillas.empleado_id','left outer')
        ->where('empleados.estado',1)
        ->where('detalleplanillas.id','<>',null)
        ->where('detalleplanillas.tipo_pago',1)
        ->where('detalleplanillas.fecha_inicio','<>',null)
        ->orderby('empleados.nombre')
        ->get();
        foreach($empleados as $empleado){
            $fecha_e=$empleado->fecha_inicio;
            $porciones = explode("-", $fecha_e);
            $date = Carbon::createFromDate($porciones[0],$porciones[1],$porciones[2])->age;
            $fecha_e=Carbon::createFromDate($porciones[0],$porciones[1],$porciones[2])->addYears($date);
            $porciones = explode("-", $fecha_e); 
            $anio=$porciones[0]; 
            if($anio==date('Y')){
                $conteo=Vacacion::where('detalleplanilla_id',$empleado->elid)->where('anio',$anio)->count();
                if($conteo==0){
                    Vacacion::create([
                        'detalleplanilla_id'=>$empleado->elid,
                        'anio'=>$anio
                    ]);
                }
            } 
        }
    }
}
