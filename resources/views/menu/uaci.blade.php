<li class="treeview {{Route::currentRouteName() == 'paacs.index' ? 'active': Route::currentRouteName()== 'paacs.show' ? 'active':null}}">
    <a href="{{ url('paacs')}}">
        <i class="fa fa-line-chart"></i> <span>Plan anual de compras</span>
    </a>
    
</li>

<li class="treeview {{Route::currentRouteName() == 'proyectos.index' ? 'active':Route::currentRouteName()== 'proyectos.show' ? 'active':null}}">
    <a href="{{ url('proyectos')}}">
        <i class="fa fa-industry"></i> <span>Proyectos</span>
    </a>
</li>

<li class="treeview {{Route::currentRouteName() == 'presupuestounidades.index' ? 'active':Route::currentRouteName()== 'presupuestounidades.show' ? 'active':null}}">
    <a href="{{url('presupuestounidades')}}">
        <i class="fa fa-pie-chart"></i>
        <span>Presupuestos</span>
    </a>
</li>

<li class="treeview {{Route::currentRouteName() == 'requisiciones.index' ? 'active':Route::currentRouteName()== 'requisiciones.show' ? 'active':null}}">
    <a href="{{url('requisiciones')}}">
        <i class="fa fa-bar-chart"></i>
        <span>Requisiciones</span>
    </a>
</li>

<li class="treeview {{ Route::currentRouteName() == 'proveedores.index' ? 'active':Route::currentRouteName()== 'proveedores.show' ? 'active':null}}">
    <a href="{{ url('proveedores') }}">
        <i class="fa fa-user-circle-o"></i>
        <span>Proveedores</span>
        <span class="pull-right-container">
              <span class="label label-primary pull-right">{{cantprov()}}</span>
            </span>
    </a>
</li>

<li class="treeview {{ Route::currentRouteName() == 'materiales.index' ? 'active': Route::currentRouteName() == 'categorias.index' ? 'active' : Route::currentRouteName() == 'unidadmedidas.index' ? 'active': null  }}">
    <a href="#">
      <i class="fa fa-share"></i> <span>Opciones para materiales</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu active">
      <li><a href="{{ url('materiales') }}"><i class="fa fa-circle-o"></i> Materiales</a></li>
      <li><a href="{{ url('categorias') }}"><i class="fa fa-circle-o"></i> Categorias para materiales</a></li>
      <li><a href="{{ url('unidadmedidas') }}"><i class="fa fa-circle-o"></i> Unidades de medida</a></li>
    </ul>
  </li>

    <li class="treeview ">
        <a href="#">
            <i class="fa fa-user-circle-o"></i>
            <span>Utilitarios</span>
            <span class="pull-right-container">
                  <span class="label label-primary pull-right"></span>
                </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ url('cargoproyectos') }}"><i class="fa fa-circle-o"></i> Cargos para los proyectos</a></li>
            <li><a href="{{ url('paaccategorias') }}"><i class="fa fa-circle-o"></i> Categorias para el Plan Anual</a></li>
            <li><a href="{{ url('giros') }}"><i class="fa fa-circle-o"></i> Giro de los proveedores</a></li>
        </ul>
    </li>

