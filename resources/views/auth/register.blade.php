@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de Usuarios</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'Auth\RegisterController@register','class' => 'form-horizontal']) }}
                    @include('errors.validacion')
                        <div id="form-register">
                          <h3>Datos Personales</h3>
                          <section>
                              <div id="scroll">
                                @include('auth.personales')
                              </div>
                          </section>
                          <h3>Datos de usuario</h3>
                          <section>
                             @include('auth.formulario')
                          </section>
                          <h3>Finalizar</h3>
                          <section>
                            <button type="submit">Guardar</button>
                          </section>
                      </div>
                   {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
