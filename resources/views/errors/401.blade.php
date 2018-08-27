@extends('layouts.app')
@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 401</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i><b> No esta autorizado.</b></h3>

            <p>
            <h4>
                No posee los privilegios para acceder a este recurso.
                Talvez tú desees <a href="{{url('/home')}}">Volver a la página de inicio</a>
            </h4>
            </p>
        </div>
        <!-- /.error-content -->
    </div>
@endsection
