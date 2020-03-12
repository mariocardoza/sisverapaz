<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $guarded = [];
    protected $fillable = ['empleado_id','issse','afpe','isssp','afpp','insaforpp','renta','prestamos','estado','datoplanilla_id','prestamos','descuentos'];
    
    public function empleado()
    {
      return $this->belongsTo('App\Empleado');
    }

    public function datoplanilla()
    {
      return $this->belongsTo('App\Datoplanilla');
    }

    public function prestamo()
    {
      return $this->belongsTo('App\Prestamo');
    }

    public static function planilla_proyecto($id)
    {
      $proyecto=Proyecto::find($id);
      $modal="";
      $modal.='<form id="form_planilla2">
      <input type="hidden" name="proyecto_id" value="'.$proyecto->id.'">
      <input type="hidden" name="tipo_pago" value="1">
      <table class="table table-striped table-bordered table-hover" >
      <thead>';
        
            $t_salario=0;
            $t_renta=0;
            $t_prestamo=0;
            $t_deduccion=0;
            $t_disponible=0;
            $sum_retenciones=0;
        $modal.='<tr>
          <th>Empleado</th>
          <th>Salario base</th>
          <th>Renta</th>
          <th>Salario líquido</th>
        </tr>
      </thead>
      <tbody>';
        foreach ($proyecto->detalleplanilla as $empleado):
        if ($empleado->pago==1):
          $modal.='<tr>
            <td>
              <input value="'.$empleado->empleado->id.'" type="hidden" name="empleado_id[]" class="form-control"/>
              '.$empleado->empleado->nombre.'
            </td>
            <td>
                <input type="hidden" name="salario[]" value="'.$empleado->salario.'">
                $'.number_format($empleado->salario,2).'<td>';  
                    
                $t_salario+=$empleado->salario;
             
              
           
            
              
             // $nogravado=$empleado->salario;
              $renta=$empleado->salario*0.1;
                $sum_retenciones+=$renta;
              
                $modal.='<input type="hidden" name="renta[]" value="'.number_format($renta,2).'">
                
              $'.number_format($renta,2).'
              
              
                  
              
              
              </td>';
            
            $t_renta+=$renta;
              
            $modal.='
            <td>$'.number_format($empleado->salario-$renta,2).'</td>';
            
                $t_deduccion+=$sum_retenciones;
                $t_disponible+=$empleado->salario-$sum_retenciones;
            
          $modal.='</tr>';
        endif;
      endforeach;
        $modal.='<tr>
          <td>
            <b>
              Totales
            </b>
          </td>
        <td><b>$'.number_format($t_salario,2).'</b></td>
          
          <td><b>$'.number_format($t_renta,2).'</b></td>
          
          <td><b>$'.number_format($t_disponible,2).'</b></td>
        </tr>
      </tbody>
    </table>
    </form>
    <center>
      <button class="btn btn-primary" data-proyecto="'.$proyecto->id.'" id="guardar_plani" type="button">Guardar</button>
      <button class="btn btn-danger" id="cance_plani" type="button">Cancelar</button>
    </center>';

    return array(1,"exito",$modal);
    }

    
}
