@extends('layouts.app')

@section('migasdepan')
<h1>&nbsp;
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Perfil</li>
      </ol>
@endsection

@section('content')
<div class="">
    <div class="row">
        <div class="col-md-5">

          <div class="panel panel-primary">
            <div class="panel-heading">Datos personales </div>
            <div class="panel-body">
              <div class="box-body box-profile">
                @if($empleado->avatar!="")
                <img class="profile-user-img img-responsive img-circle" src="{{ $empleado->img_path }}" id="img_file" alt="User profile picture">
                @else
              <img class="profile-user-img img-responsive img-circle" src="{{ asset('avatars/avatar.jpg') }}" id="img_file" alt="User profile picture">
              @endif
              <form method='post' action="{{ url('empleados/foto/'.$empleado->id) }}" enctype='multipart/form-data'>
                {{csrf_field()}}
              <input type="file" class="archivos hidden" id="file_1" name="foto" />
              <center><button type="submit" class="btn btn-success" style="display: none;" id="elquecambia">Cambiar</button></center>
              </form>
              <div class="form-group">
                <div id="error_formato1" class="hidden"><span style="color: red;">Formato de archivo invalido. Solo se permiten los formatos JPG y PNG.</span>
                </div>
              </div>
              
              <h3 class="profile-username text-center">{{$empleado->nombre}}</h3>

              
                <?php if ($empleado->es_usuario=='si' && $empleado->user): ?>
                  <p class="text-muted text-center">
                    {{$empleado->user->roleuser->role->description}}</p>
                  <?php else: ?>
                  <p class="text-muted text-center">Empleado</p>
                <?php endif ?>
            

              </div>
              <table class="table">
                <tr>
                  <td>Número de DUI</td>
                  <th>{{$empleado->dui}}</th>
                </tr>
                <tr>
                  <td>Número de NIT</td>
                  <th>{{$empleado->nit}}</th>
                </tr>
                <tr>
                  <td>Sexo</td>
                  <th>{{$empleado->sexo}}</th>
                </tr>
                <tr>
                  <td>Número de teléfono</td>
                  <th>{{$empleado->telefono_fijo}}</th>
                </tr>
                <tr>
                  <td>Número de celular</td>
                  <th>{{$empleado->celular}}</th>
                </tr>
                <tr>
                  <td>Dirección</td>
                  <th>{{$empleado->direccion}}</th>
                </tr>
                <tr>
                  <td>Fecha de nacimiento</td>
                  <th>{{$empleado->fecha_nacimiento->format("d/m/Y")}}</th>
                </tr>
                <tr>
                  <td>Edad</td>
                  <th>{{$empleado->fecha_nacimiento->age}}</th>
                </tr>
              </table>

              <center>
              
              <a id="modal_editar" class="btn btn-warning"><span class="fa fa-edit"></span> Editar</a>
      
                <!--button class="btn btn-danger" type="button" id="dar_baja"><span class="glyphicon glyphicon-trash"></span> Eliminar</button-->
              
              </center>
            </div>
          </div>
        </div>
        
        <div class="col-md-7">
          <div class="btn-group">
            @if(isset($empleado->detalleplanilla) && $empleado->detalleplanilla->proyecto_id =='')
            <button class="btn btn-primary que_ver" type="button" data-opcion="2">Información</button>
            <button class="btn btn-primary que_ver" type="button" data-opcion="3">Descuentos</button>
            @endif
          </div>
          <br><br>
          <div class="row" id="general" >
            <?php if ($empleado->es_usuario=='si'): ?>
             <div class="col-md-10">
              <div class="panel panel-primary">
                <div class="panel-heading">Datos de inicio de sesión</div>
                <div class="panel-body">
                  <form action="">
                    <div class="form-group">
                      <?php if ($empleado->user): ?>
                        <table class="table">
                          <tr>
                            <td>Nombre de usuario</td>
                            <th>{{$empleado->user->username}}</th>
                          </tr>
                          <tr>
                            <td>Correo electrónico</td>
                            <th>{{$empleado->user->email}}</th>
                          </tr>
                          @if(isset($empleado->user->unidad_id))
                          <tr>
                            <td>Unidad</td>
                            <th>{{$empleado->user->unidad->nombre_unidad}}</th>
                          </tr>
                          @endif
                        </table>
                        
                        <center><button class="btn btn-warning btn-sm" id="editar_usuario" type="button">Editar información</button></center>
                       
                      <?php else: ?>
                        <center>
                          <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                          <span>Aun no han sido asignados las credenciales para iniciar sesión</span><br>
                          
                        </center>
                      
                    <?php endif; ?>
                      
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endif ?>
            <div class="col-md-10">
              <div class="panel panel-primary">
                <div class="panel-heading">Datos bancarios</div>
                <div class="panel-body">
                  <form action="">
                    <div class="form-group">
                      <?php if ($empleado->num_cuenta): ?>
                        <table class="table">
                          <tr>
                            <td>Banco</td>
                            <th>{{$empleado->banco->nombre}}</th>
                          </tr>
                          <tr>
                            <td>Numero de cuenta</td>
                            <th>{{$empleado->num_cuenta}}</th>
                          </tr>
                        </table>
                      <?php else: ?>
                        <center>
                          <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                          <span>Agregue los datos bancarios para visualizar la información</span><br>
                         
                        </center>
                      
                    <?php endif; ?>
                      
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div class="col-md-10">
              <div class="panel panel-primary">
                <div class="panel-heading">Datos del AFP</div>
                <div class="panel-body">
                  <?php if ($empleado->num_afp): ?>
                    <table class="table">
                    <tr>
                      <td>Nombre de la AFP</td>
                      <th>{{$empleado->afp->nombre}}</th>
                    </tr>
                    <tr>
                      <td>Numero del AFP</td>
                      <th>{{$empleado->num_afp}}</th>
                    </tr>
                  </table>
                    <?php else: ?>
                      <center>
                        <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                        <span>Agregue datos del AFP para visualizar la información</span><br>
                        
                      </center>
                  <?php endif ?>
                </div>
              </div>
            </div>

            <div class="col-md-10">
              <div class="panel panel-primary">
                <div class="panel-heading">Datos del Seguro Social</div>
                <div class="panel-body">

                  <?php if ($empleado->num_seguro_social): ?>
                    <table class="table">
                    <tr>
                      <td>Número del ISSS</td>
                      <th>{{$empleado->num_seguro_social}}</th>
                    </tr>
                  </table>
                    <?php else: ?>
                      <center>
                        <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                        <span>Agregue datos del ISSS para visualizar la información</span><br>
                      
                      </center>
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="descuentos" style="display: none;">
            <div class="col-md-10">
              <div class="panel panel-primary">
                <div class="panel-heading">Préstamos</div>
                <div class="panel">
                  
                  <table class="table">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Banco</th>
                      <th>N° de cuenta</th>
                      <th>Monto</th>
                      <th>Cuota</th>
                      <th>Tipo</th>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($empleado->prestamo as $key => $prestamo): ?>
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$prestamo->banco->nombre}}</td>
                        <td>{{$prestamo->numero_de_cuenta}}</td>
                        <td>${{number_format($prestamo->monto,2)}}</td>
                        <td>${{number_format($prestamo->cuota,2)}}</td>
                        <td>{{$prestamo->prestamotipo->nombre}}</td>
                        <td><button class="btn btn-primary btn-sm" type="button" id="ver_prestamo"><i class="fa fa-eye"></i></button></td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
                </div>
              </div>
              <br>

              <div class="panel panel-primary">
                <div class="panel-heading">Otros descuentos</div>
                <div class="panel">
                  
                  
                  <table class="table">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>Descuento</th>
                        <th>Cuota</th>
                        <td></td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($empleado->descuento as $key => $descuento): ?>
                        <tr>
                          <td>{{$key+1}}</td>
                          <td>{{$descuento->categoriadescuento->nombre}}</td>
                          <td>${{number_format($descuento->cuota,2)}}</td>
                          <td><button class="btn btn-primary btn-sm" type="button" id="ver_prestamo"><i class="fa fa-eye"></i></button></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
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
                    <div class="col-sm-12 col-md-6">
                       <div class="form-group">
                          <label for="username" class="control-label">Nombre de Usuario</label>
      
                          <div class="">
                              <input id="username" type="text" autocomplete="off" class="form-control" name="username" value="{{$empleado->user->username}}">
                              <input id="empleado_id" type="hidden" autocomplete="off" class="form-control" name="elempleado" value="{{$empleado->id}}">
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <div class="form-group">
                        <label for="" class="control-label">Email</label>
                      <input type="text" name="email" value="{{$empleado->user->email}}" class="form-control">
                      </div>
                    </div>
                      <br>
                      <div class="col-sm-12">
                        <h4>Si no desea cambiar la contraseñas dejar en blanco</h4>
                      </div>
                      <div class="col-md-12">
                      <div class="form-group">
                          <label for="" class="control-label">Contraseña actual</label>
                          <input type="password" name="contra_actual" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="" class="control-label">Contraseña nueva</label>
                        <input id="password" type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Confirmar contraseña</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                    </div>
                    </div>
                </div>
                <?php endif ?>
              </form>
            </div>
            <div class="modal-footer">
                <center>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <button type="button" id="eledit_user" class="btn btn-success">Editar</button></center>
            </div>
          </div>
        </div>
      </div>
    
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
  elempleado='<?php echo $empleado->id ?>';
</script>
{!! Html::script('js/empleados.js?cod='.date('Yidisus')) !!}
@endsection
