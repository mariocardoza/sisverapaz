<ul class="sidebar-menu">
        <li class="header">Menú Principal</li>
        <li class="{{Route::currentRouteName() =='home' ? 'active' : null}}"><a href="{{url('/home')}}">Página de inicio</a></li>
    @if(Auth()->user()->hasRole('admin'))
    <li class="treeview {{ Route::currentRouteName() == 'configuraciones.create' ? 'active':null}}">
      <a href="{{ url('configuraciones') }}">
        <i class="glyphicon glyphicon-cog"></i><span>Administración</span>
      </a>
    </li>

    <li class="treeview ">
      <a href="{{ url('/rentas') }}">
        <i class="glyphicon glyphicon-tasks"></i> <span>Porcentajes Impuesto/renta</span>
      </a>
     
    </li>

    <li class="treeview ">
      <a href="{{ url('/bitacoras/general') }}">
        <i class="glyphicon glyphicon-tasks"></i> <span>Bitácora</span>
      </a>
     
    </li>

    <li class="treeview {{ Route::currentRouteName() == 'usuarios.index' ? 'active':null}}">
      <a href="{{ url('/usuarios') }}">
        <i class="fa fa-user"></i> <span>Usuarios</span>
      </a>
      
    </li>

    <li class="treeview {{ Route::currentRouteName() == 'empleados.index' ? 'active':Route::currentRouteName() == 'empleados.show'?'active':null}}">
      <a href="{{ url('/empleados') }}">
        <i class="fa fa-user"></i> <span>Empleados</span>
      </a>
      
    </li>

    <li class="treeview {{ Route::currentRouteName() == 'backups.index' ? 'active':null}}">
      <a href="{{ url('/backups') }}">
        <i class="glyphicon glyphicon-hdd"></i><span>Respaldos</span>
      </a>
    </li>

    <li class="treeview {{ Route::currentRouteName() == 'unidades.index' ? 'active':null}}">
      <a href="{{ url('/unidades') }}">
        <i class="fa fa-list"></i><span>Unidades administrativas</span>
      </a>
    </li>

    <li class="treeview {{ Route::currentRouteName() == 'cargos.index' ? 'active': Route::currentRouteName() == 'catcargos.index' ? 'active' : null }}">
      <a href="#">
        <i class="fa fa-list"></i><span>Cargos</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{ url('catcargos') }}"><i class="fa fa-circle-o"></i> Categorías para los cargos </a></li>
        <li><a href="{{ url('cargos') }}"><i class="fa fa-circle-o"></i> Cargos </a></li>  
    </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-share"></i> <span>Misceláneos</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{url('afps')}}"><i class="fa fa-circle-o"></i> AFPS</a></li>
        <li><a href="{{url('bancos')}}"><i class="fa fa-circle-o"></i> Bancos</a></li>
        <li><a href="{{url('giros')}}"><i class="fa fa-circle-o"></i> Giro de proveedores</a></li>
        <li><a href="{{url('servicios')}}"><i class="fa fa-circle-o"></i> Listado de servicios</a></li>
      </ul>
    </li>
    
    @endif
    @if(Auth()->user()->hasRole('uaci'))
    @include('menu.uaci')
    @endif
    @if(Auth()->user()->hasRole('tesoreria'))
      @include('menu.tesoreria')
    @endif
    @if(Auth()->user()->hasRole('catastro'))
      @include('menu.ryct')
    @endif
    <li class="treeview">
      <a href="#">
        <i class="fa fa-share"></i> <span>Multinivel</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
        <li>
          <a href="#"><i class="fa fa-circle-o"></i> Level One
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> Level Two
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
      </ul>
    </li>
</ul>
