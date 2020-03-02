@extends('layouts.app')
@php
    $unid=App\Unidad::where('estado',1)->get();
    $unidades=[];
    foreach ($unid as $u ) {
        $unidades[$u->id]=$u->nombre_unidad;
    }

    
      $roles = App\Role::all();
      $empleados = \DB::table('empleados')->where('es_usuario','=','si')
                    ->whereNotExists(function ($query)  {
                         $query->from('users')
                            ->whereRaw('empleados.id = users.empleado_id');
                        })->get();
  @endphp
@section('migasdepan')
<h1>
        Usuarios
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de Usuarios</li>
      </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"></h3>
                  <div class="btn-group pull-right">
                    <a href="javascript:void(0)" id="md_user" class="btn btn-success">Agregar <span class="glyphicon glyphicon-plus-sign"></span></a>
                    <a href="{{ url('/usuarios?estado=1') }}" class="btn btn-primary">Activos</a>
                    <a href="{{ url('/usuarios?estado=2') }}" class="btn btn-primary">Papelera</a>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-bordered table-striped" id="example2">
      				<thead>
                      <th>N°</th>
                      <th>Nombre completo</th>
                      <th>Nombre de Usuario</th>
                      <th>Correo electrónico</th>
                      <th>Rol</th>
                      <th>Unidad administrativa</th>
                      <th>Acción</th>
                    </thead>
                    <tbody>
                    	@foreach($usuarios as $key => $user)
                    	<tr>
                    		<td>{{ $key+1 }}</td>
                    		<td>{{ $user->empleado->nombre }}</td>
                    		<td>{{ $user->username }}</td>
                    		<td>{{ $user->email }}</td>
                        <td>{{ $user->roleuser->role->description }}</td>
                        <td>{{ $user->unidad->nombre_unidad }}</td>
                    		<td>
                          @if($user->estado == 1 )
                              {{ Form::open(['method' => 'POST',  'class' => 'form-horizontal'])}}          
                                <a href="javascript:void(0)" id="eledit" data-id="{{$user->id}}" class="btn btn-warning"><span class="fa fa-edit"></span></a>
                                <button class="btn btn-danger" type="button" onclick={{ "baja(".$user->id.",'usuarios')" }}><span class="glyphicon glyphicon-trash"></span></button>
                            {{ Form::close()}}
                          @else
                              {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal'])}}
                              <button class="btn btn-success" type="button" onclick={{ "alta(".$user->id.",'usuarios')" }}><span class="glyphicon glyphicon-trash"></span></button>
                              {{ Form::close()}}
                          @endif
                        </td>
                    	</tr>
                    	@endforeach
                    </tbody>
                  </table>

                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
  </div>
  <div class="modal fade" tabindex="-1" id="modal_usuario" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center" id="gridSystemModalLabel">Registrar usuario del sistema</h4>
        </div>
        <div class="modal-body">
          <form id="fm_user">    	
         <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="name" class="control-label">Nombre</label>
  
                <select class="chosen-select-width" name="name">
                  <option value="">Seleccione</option>
                  @foreach ($empleados as $contrato)
                    <option value="{{$contrato->id}}">{{$contrato->nombre}}</option>
                  @endforeach
                </select>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="username" class="control-label">Nombre de Usuario</label>
  
              <div class="">
                  <input type="text" class="form-control" name="username" value="" >
                 
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="email" class="control-label">E-Mail</label>
  
              <div class="">
                  <input type="text" class="form-control" name="email">
  
    
              </div>
            </div>
          </div>


        <div class="col-md-6">
          <div class="form-group">
            <label for="unidad_id" class="control-label">Unidad</label>
            <div class="">
                {!! Form::select('unidad_id',$unidades,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione una unidad administrativa']) !!}
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="control-label">Contraseña</label>

            <div class="">
                <input id="password" type="password" class="form-control" name="password">

        
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="password" class="control-label">Rol del usuario</label>

            <div class="">
                <select class="chosen-select-width" name="roles">
                  @foreach($roles as $rol)
                    <option value="{{$rol->id}}">{{$rol->description}}</option>
                  @endforeach
                </select>
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

          

          
          
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Registrar</button></center>
        </div>
      </form>
      </div>
    </div>
  </div>
  <div id="modal_aqui"></div>
@endsection

@section('scripts')
<script>
  $(document).ready(function(e){

    //modal registrar usuario
    $(document).on("click","#md_user",function(e){
      $("#modal_usuario").modal("show");
    });

    $(document).on("submit","#fm_user",function(e){
      e.preventDefault();
      var datos=$("#fm_user").serialize();
      $.ajax({
        url:'usuarios',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("usuario registrado con éxito");
            location.reload();
          }else{

          }
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	});
	          	swal.closeModal();
        }
      });
    });

    //modal para editar
    $(document).on("click","#eledit",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      $.ajax({
        url:'usuarios/'+id+'/edit',
        type:'get',
        dataType:'json',
        success: function(json){
          if(json[0]==1){
            $("#modal_aqui").empty();
            $("#modal_aqui").html(json[2]);
            $("#modal_e_usuario").modal("show");
            $(".chosen-select-width").chosen({
              'width':'100%'
            });
          }
        },
        error: function(error){
          toastr.error("Ocurrió un error al cargar la información");
        }
      });
    })
  });
</script>
@endsection
