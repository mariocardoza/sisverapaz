<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empleado_id','username', 'email', 'password','cargo','unidad_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['created_at'];

    public function bitacora()
    {
        return $this->hasMany('App\Bitacora');
    }

    public function unidad()
    {
      return $this->belongsTo('App\Unidad')->withDefault();
    }

    public function empleado()
    {
      return $this->belongsTo('App\Empleado');
    }

    public function roles()
    {
      return $this
        ->belongsToMany('App\Role')
        ->withTimestamps();
    }

    public function roleuser()
    {
      return $this->hasOne('App\RoleUser');
    }

    public function authorizeRoles($roles)
    {
      if ($this->hasAnyRole($roles)) {
        return true;
      }
      abort(401, 'Esta acción no está autorizada.');
    }
    public function hasAnyRole($roles)
    {
      if (is_array($roles)) {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
      } else {
        if ($this->hasRole($roles)) {
            return true;
        }
      }
    return false;
  }
public function hasRole($role)
{
    if ($this->roles()->where('name', $role)->first()) {
        return true;
    }
    return false;
}

  public static function modal_editar($id)
  {
    $html='';
    $user=User::find($id);
    $unidades=Unidad::where('estado',1)->get();
   

    
      $roles = Role::all();
      $empleados = \DB::table('empleados')->where('es_usuario','=','si')
                    ->whereNotExists(function ($query)  {
                         $query->from('users')
                            ->whereRaw('empleados.id = users.empleado_id');
                        })->get();
    $html.='<div class="modal fade" tabindex="-1" id="modal_e_usuario" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center" id="gridSystemModalLabel">Editar el usuario</h4>
        </div>
        <div class="modal-body">
          <form id="fm_euser">    	
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name" class="control-label">Nombre</label>
      
                    <select class="chosen-select-width" name="name">
                      <option value="'.$user->empleado->id.'">'.$user->empleado->nombre.'</option>';
                    
                    $html.='</select>
                </div>
              </div>
            </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username" class="control-label">Nombre de Usuario</label>

                    <div class="">
                        <input type="text" class="form-control" name="username" value="'.$user->username.'" >
                      
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="control-label">E-Mail</label>

                    <div class="">
                        <input type="text" class="form-control" name="email" value="'.$user->email.'">
                    </div>
                  </div>
                </div>
              </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="unidad_id" class="control-label">Unidad</label>
                  <div class="">
                      <select class="chosen-select-width" name="unidad_id">
                        <option value="">Seleccione una unidad administrativa</option>';
                        foreach ($unidades as $u):
                          if($u->id==$user->unidad_id):
                          $html.='<option selected value="'.$u->id.'">'.$u->nombre_unidad.'</option>';
                          else:
                            $html.='<option value="'.$u->id.'">'.$u->nombre_unidad.'</option>';
                          endif;
                        endforeach;
                      $html.='</select>
                  </div>
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password" class="control-label">Rol del usuario</label>
        
                    <div class="">
                        <select class="chosen-select-width" name="roles">
                          <option value="">Seleccione un rol</option>';
                          foreach($roles as $rol):
                            if($rol->id==$user->roleuser->role_id):
                            $html.='<option selected value="'.$rol->id.'">'.$rol->description.'</option>';
                            else:
                              $html.='<option value="'.$rol->id.'">'.$rol->description.'</option>';
                            endif;
                          endforeach;
                        $html.='</select>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="form-group">
                <center><label for="">¿Actualizar contraseña?</label>
                <input type="checkbox" id="laclave"> </center>
              </div>
            </div>
            <div class="row lacontra" style="display: none;">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password" class="control-label">Contraseña</label>
      
                  <div class="">
                      <input id="epassword" disabled type="password" class="form-control" name="password">
      
              
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group ">
                  <label for="password-confirm" class="control-label">Confirmar Contraseña</label>
      
                    <div class="">
                        <input id="epassword-confirm" disabled type="password" class="form-control" name="password_confirmation">
                    </div>
                  </div>
              </div>
            </div>
          
          </div>
        </form>
    
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="button" id="edit_user" data-id="'.$user->id.'" class="btn btn-success">Registrar</button></center>
        </div>
      
      </div>
    </div>
  </div>';

  return array(1,"exito",$html);
  }

}
