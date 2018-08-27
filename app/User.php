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
        'empleado_id','username', 'email', 'password','cargo',
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

}
