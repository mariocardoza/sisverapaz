<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $fillable = ['name','descripcion'];

  public function users()
  {
    return $this
      ->belongsToMany('App\User')
      ->withTimestamps();
    }

    public function roleuser()
    {
      return $this->hasOne('App\RoleUser');
    }
}
