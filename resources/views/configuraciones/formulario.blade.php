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
    								<span class="glyphicon glyphicon-floppy-disk">Registrar</span>
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
            <div class="row">
              <div class="col-md-12" style="text-align: center;">
                <h1>Logo alcaldia</h1>
                @if($configuraciones!='')
                <!--img src="{{ $configuraciones->url_path }}" id="img_file" width="150" height="200" class="user-image" alt="User Image"-->
                <form method='post' action="{{ url('configuraciones/logo/'.$configuraciones->id) }}" enctype='multipart/form-data'>
                @else 
                <!--img src="{{ asset('img/logos/escudo.png') }}" id="img_file" width="150" height="200" class="user-image" alt="User Image"-->
                <form method='post' action="{{ url('configuraciones/logog') }}" enctype='multipart/form-data'>
                @endif
    					  {{csrf_field()}}
    					
                  <div class='form-group text-center'>
                    <input type="file" class="hidden" name="logo" id="file_1" />
                    <div class='text-danger'>{{$errors->first('avatar')}}</div>
                  </div>
                  <button type='submit' class='btn btn-primary elsub' style="display: none;">Cambiar</button>
                
    				</form>
              </div>
            </div>
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
                    <span class="glyphicon glyphicon-floppy-disk">Registrar</span>
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
      <h3>Montos límites de proyectos</h3>
      <section>
        <div class="panel panel-default">
          <div class="panel-body">
            @if($configuraciones != null)
              {{ Form::model($configuraciones, array('method' => 'put', 'class' => 'form-horizontal','autocomplete'=>'off' , 'route' => array('configuraciones.ulimites', $configuraciones->id))) }}
            @else
              {{ Form::open(['action'=> 'ConfiguracionController@limitesproyecto', 'class' => 'form-horizontal','autocomplete'=>'off']) }}
            @endif
            @include('configuraciones.limites')
            @if($configuraciones != null)
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-disk">Registrar</span>
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

  
