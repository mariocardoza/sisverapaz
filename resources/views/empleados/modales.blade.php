@php
    $unid=App\Unidad::where('estado',1)->get();
    $unidades=[];
    foreach ($unid as $u ) {
        $unidades[$u->id]=$u->nombre_unidad;
    }
    $elrol=App\Role::all();
    $roles=[];
    foreach ($elrol as $r ) {
      $roles[$r->id]=$r->description;
    }
@endphp
<div class="modal fade" tabindex="-1" id="modal_bancarios" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar datos bancarios</h4>
      </div>
      <div class="modal-body">
      	<form id="bancarios" action="" class="form-horizontal">
      		<div class="row">
	          	<div class="col-md-12">
		          	<div class="form-group">
		                <label class="control-label col-md-4">Seleccione el banco</label>
		                <div class="col-md-6">
		                	<input type="hidden" name="codigo" value="{{$empleado->id}}">
		                    {{Form::select('banco',$bancos,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione un banco','required'])}}
		                </div>       
		            </div>

		            <div class="form-group">
		                <label class="control-label col-md-4">Número de cuenta</label>
		                <div class="col-md-6">
		                    {{ Form::number('num_cuenta', null,['id'=>'cuenta_empleado','class' => 'form-control','autocomplete'=>'off','required']) }}
		                </div>       
		            </div>
	          	</div>
	        </div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_bancarios" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_afp" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar datos de la AFP</h4>
      </div>
      <div class="modal-body">
      	<form id="afps" action="" class="form-horizontal">
      		<div class="row">
	          	<div class="col-md-12">
		          	<div class="form-group">
		                <label class="control-label col-md-4">Seleccione la AFP</label>
		                <div class="col-md-6">
		                	<input type="hidden" name="codigo" value="{{$empleado->id}}">
		                    {{Form::select('afp',$afps,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione una AFP','required'])}}
		                </div>       
		            </div>

		            <div class="form-group">
		                <label class="control-label col-md-4">Número de afp</label>
		                <div class="col-md-6">
		                    {{ Form::number('num_afp', null,['id'=>'afp_empleado','class' => 'form-control','autocomplete'=>'off','required']) }}
		                </div>       
		            </div>
	          	</div>
	        </div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_afp" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modales_isss" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar número de Seguro Social</h4>
      </div>
      <div class="modal-body">
      	<form id="isss" action="" class="form-horizontal">
      		<div class="row">
	          	<div class="col-md-12">
		          	

		            <div class="form-group">
		                <label class="control-label col-md-4">Número de Seguro Social</label>
		                <div class="col-md-6">
		                	<input type="hidden" name="codigo" value="{{$empleado->id}}">
		                    {{ Form::number('num_seguro_social', null,['id'=>'isss_empleado','class' => 'form-control','autocomplete'=>'off','required']) }}
		                </div>       
		            </div>
	          	</div>
	        </div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_isss" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_edit" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="gridSystemModalLabel">Editar empleado</h4>
      </div>
      <div class="modal-body">
      	{{ Form::model($empleado, array('class' => '','id'=>'e_empleados')) }}    	
					@include('empleados.formulario') 
      	</form>
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_editar" class="btn btn-success">Registrar</button></center>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_user" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar datos del usuario</h4>
      </div>
      <div class="modal-body">
      	<form id="n_usuario">
      		<div class="row">
	          	<div class="col-md-12">
		          	
					

                         <div class="form-group">
                            <label for="username" class="control-label">Nombre de Usuario</label>

                            <div class="">
                                <input id="username" type="text" autocomplete="off" class="form-control" name="username">
                                <input id="empleado_id" type="hidden" autocomplete="off" class="form-control" name="elempleado" value="{{$empleado->id}}">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">E-Mail</label>

                            <div class="">
                                <input id="email" value="{{$empleado->email}}" readonly type="text" class="form-control" name="email">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unidad_id" class="col-md-4 control-label">Unidad</label>
                            <div class="col-md-6">
                                {!! Form::select('unidad_id',$unidades,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione una unidad administrativa']) !!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Rol del usuario</label>

                            <div class="">
                                 {{Form::select('roles',$roles,null, ['class'=>'form-control','placeholder'=>'Seleccione un rol'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class=" control-label">Contraseña</label>

                            <div class="">
                                <input id="password" type="password" class="form-control" name="password">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="control-label">Confirmar Contraseña</label>

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
		           
	          	</div>
	        </div>
      	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="registrar_user" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="editar_user" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Editar datos del usuario</h4>
      </div>
      <div class="modal-body">
        {{ Form::model($empleado->user, array('class' => '','id'=>'e_usuarios')) }} 
        <?php if ($empleado->es_usuario=='si' && $empleado->user): ?>
          <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                    <label for="username" class="control-label">Nombre de Usuario</label>

                    <div class="">
                      
                        
                     
                        <input id="username" type="text" autocomplete="off" class="form-control" name="username" value="{{$empleado->user->username}}">
                        <input id="empleado_id" type="hidden" autocomplete="off" class="form-control" name="elempleado" value="{{$empleado->id}}">
                        
                         
                    </div>
                </div>
                <div class="form-group">
                  <label for="" class="control-label">Email</label>
                <input type="text" name="email" value="{{$empleado->user->email}}" class="form-control">
                </div>
                <div class="form-group">
                  <label for="" class="control-label">Rol de usuario</label>
                  <div>
                      {!! Form::select('unidad_id',$roles,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione un rol de usuario']) !!}
                  </div>
                </div>

                <div class="form-group">
                  <label for="" class="control-label">Unidad</label>
                  <div>
                      {!! Form::select('unidad_id',$unidades,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione una unidad administrativa']) !!}
                  </div>
                </div>
         
              </div>
          </div>
          <?php endif ?>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="eledit_user" class="btn btn-primary">Editar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="md_prestamo" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar préstamo</h4>
      </div>
      <div class="modal-body">
        <form action="" id="form_prestamo" class="form-horizontal"> 
          <div class="row">
              <div class="col-md-12">
                 @include('prestamos.formulario')

         
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="regi_prestamo" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="md_descuento" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar descuento</h4>
      </div>
      <div class="modal-body">
        <form action="" id="form_descuento" class="form-horizontal"> 
          <div class="row">
              <div class="col-md-12">
                 @include('descuentos.formulario')

         
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="regi_descuento" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>