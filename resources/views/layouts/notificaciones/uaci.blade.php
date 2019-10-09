@php
    $cn=0;//Contador de notificaciones
    $pendientes=App\Requisicione::where('anio',date("Y"))->where('estado',1)->count();//Empleados pendientes de vacación
    if($pendientes!=0){
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
        @if($pendientes!=0)
            @if($pendientes==1)
            <li>
                <a href="{{ url('/requisiciones') }}">
                  <i class="fa fa-user text-red"></i>Tiene {{$pendientes}} requisición pendiente de aprobación
                </a>
              </li>
            @else
            <li>
                <a href="{{ url('/requisiciones') }}">
                  <i class="fa fa-user text-red"></i>Tiene {{$pendientes}} requisiciones pendientes de aprobación
                </a>
              </li>
            @endif
          
        @endif
        </ul>
      </li>
      <li class="footer"><a href="#">View all</a></li>
    </ul>
</li>