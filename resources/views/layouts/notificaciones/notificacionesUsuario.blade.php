@if (Auth()->user())
  @if(Auth()->user()->hasRole('tesoreria') || Auth()->user()->hasRole('admin'))
      @include('layouts.notificaciones.administrador')
  @elseif(Auth()->user()->hasRole('uaci'))
    @include('layouts.notificaciones.uaci')
  @else
  {{-- Código default de mensajes --}}
  <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning">10</span>
      </a>
      <ul class="dropdown-menu">
        <li class="header">You have 10 notifications</li>
        <li>
          <!-- inner menu: contains the actual data -->
          <ul class="menu">
            <li>
              <a href="#">
                <i class="fa fa-users text-aqua"></i> 5 new members joined today
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                page and may cause design problems
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-users text-red"></i> 5 new members joined
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-shopping-cart text-green"></i> 25 sales made
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-user text-red"></i> You changed your username
              </a>
            </li>
          </ul>
        </li>
        <li class="footer"><a href="#">View all</a></li>
      </ul>
  </li>
  @endif    
@endif