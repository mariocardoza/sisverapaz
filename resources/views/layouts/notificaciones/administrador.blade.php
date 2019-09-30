@php
    $cn=0;//Contador de notificaciones
    $empleadosv=App\Vacacion::where('fecha_vacacion',null)->count();//Empleados pendientes de vacación
    if($empleadosv!=0){
        $cn++;
    }
@endphp
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
    <span class="label label-warning">{{$cn}}</span>
    </a>
    <ul class="dropdown-menu">
      <li class="header">Tienes {{$cn}} notificaciones</li>
      <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu">
        @if($empleadosv!=0)
          <li>
            <a href="{{ url('/vacaciones') }}">
              <i class="fa fa-user text-red"></i>Asignar vacaciones a {{$empleadosv}} empleados
            </a>
          </li>
        @endif
        </ul>
      </li>
      <li class="footer"><a href="#">View all</a></li>
    </ul>
</li>