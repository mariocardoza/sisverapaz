<div id="form-configuracion">
      <h3>Datos generales de la alcaldía</h3>
      <section>
        <div class="panel panel-default">
          <div class="panel-body">

            @if($configuraciones != null)
              {{ Form::model($configuraciones, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('configuraciones.ualcaldia', $configuraciones->id))) }}
            @else
              {{ Form::open(['action'=> 'ConfiguracionController@alcaldia', 'class' => 'form-horizontal']) }}
            @endif
            @include('configuraciones.alcaldia')
            @if($configuraciones != null)
              <div class="form-group">
    						<div class="col-md-6 col-md-offset-4">
    							<button type="submit" class="btn btn-success">
    								<span class="glyphicon glyphicon-floppy-disk">Modificar</span>
    							</button>
    						</div>
    					</div>
            @else
  					<div class="form-group">
  						<div class="col-md-6 col-md-offset-4">
  							<button type="submit" class="btn btn-success">
  								<span class="glyphicon glyphicon-floppy-disk">Registrar</span>
  							</button>
  						</div>
  					</div>
          @endif

          {{Form::close()}}
          </div>
        </div>
      </section>
      <h3>Logo</h3>
      <section>
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Logo alcaldia</h1>
    				<img src="{{ asset('img/logos/'.$configuraciones->escudo_alcaldia) }}" id="img_file" width="150" height="200" class="user-image" alt="User Image">
    				<form method='post' action="{{ url('configuraciones/logo/'.$configuraciones->id) }}" enctype='multipart/form-data'>
    					{{csrf_field()}}
    					<div class='form-group'>
    						<input type="file" class="hidden" name="logo" id="file_1" />
    						<div class='text-danger'>{{$errors->first('avatar')}}</div>
    					</div>
    					<button type='sutmit'  class='btn btn-primary'>Cambiar</button>
    				</form>
          </div>
        </div>
      </section>
      <h3>Datos personales del alcalde</h3>
      <section>
        <div class="panel panel-default">
          <div class="panel-body">
            @if($configuraciones != null)
              {{ Form::model($configuraciones, array('method' => 'put', 'class' => 'form-horizontal','autocomplete'=>'off' , 'route' => array('configuraciones.ualcalde', $configuraciones->id))) }}
            @else
              {{ Form::open(['action'=> 'ConfiguracionController@alcalde', 'class' => 'form-horizontal','autocomplete'=>'off']) }}
            @endif
            @include('configuraciones.alcalde')
            @if($configuraciones != null)
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-disk">Modificar</span>
                  </button>
                </div>
              </div>
            @else
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-success">
                  <span class="glyphicon glyphicon-floppy-disk">Registrar</span>
                </button>
              </div>
            </div>
          @endif
          {{Form::close()}}
          </div>
        </div>
      </section>
  </div>

  
