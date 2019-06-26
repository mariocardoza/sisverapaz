@extends('layouts.app')

@section('migasdepan')
<h1>&nbsp;
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/empleados') }}"><i class="fa fa-dashboard"></i> Empleados</a></li>
        <li class="active">Perfil</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">

          <div class="panel panel-primary">
            <div class="panel-heading">Datos del empleado </div>
            <div class="panel-body">
              <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ asset('avatars/'.Auth::user()->avatar) }}" id="img_file" alt="User profile picture">
              <input type="file" class="archivos hidden" id="file_1" name="file_1" />
              <div class="form-group">
                <div id="error_formato1" class="hidden"><span style="color: red;">Formato de archivo invalido. Solo se permiten los formatos JPG y PNG.</span>
                </div>
              </div>
              
              <h3 class="profile-username text-center">{{$empleado->nombre}}</h3>

              <p class="text-muted text-center">{{Auth()->user()->roleuser->role->description}}</p>

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
        
        <div class="col-md-6">
          <div class="row">
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
                        </table>
                      <?php else: ?>
                        <center>
                          <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                          <span>Agregue los datos para iniciar sesión</span><br>
                          <button class="btn btn-primary" id="modal_usuarios">Agregar</button>
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
                          <button class="btn btn-primary" id="modal_banco">Agregar</button>
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
                        <button class="btn btn-primary" id="modal_afps">Agregar</button>
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
                      <td>Numero del ISSS</td>
                      <th>{{$empleado->num_seguro_social}}</th>
                    </tr>
                  </table>
                    <?php else: ?>
                      <center>
                        <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                        <span>Agregue datos del ISSS para visualizar la información</span><br>
                        <button class="btn btn-primary" id="modal_isss">Agregar</button>
                      </center>
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div>
        </div>


    </div>
    @include('empleados.modales')
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  elempleado='<?php echo $empleado->id ?>';
</script>
{!! Html::script('js/empleados.js?cod='.date('Yidisus')) !!}
@endsection
