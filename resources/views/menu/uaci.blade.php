<li class="treeview {{Route::currentRouteName() == 'paacs.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-line-chart"></i> <span>Plan anual de compras</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{ url('paacs')}}"><i class="fa fa-circle-o"></i> listado de plan anual</a></li>
    </ul>
</li>

<li class="treeview {{Route::currentRouteName() == 'proyectos.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-industry"></i> <span>Proyectos</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('proyectos')}}"><i class="fa fa-circle-o"></i> Listado de Proyectos</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-pie-chart"></i>
        <span>Presupuestos</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('presupuestounidades')}}"><i class="fa fa-circle-o"></i> Ver presupuesto</a></li>
    </ul>
</li>

<li class="treeview {{Route::currentRouteName() == 'requisiciones.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-bar-chart"></i>
        <span>Requisicion</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('requisiciones')}}"><i class="fa fa-circle-o"></i> Ver requisiciones</a></li>
    </ul>
</li>

<li class="treeview {{ Route::currentRouteName() == 'proveedores.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-user-circle-o"></i>
        <span>Proveedores</span>
        <span class="pull-right-container">
              <span class="label label-primary pull-right">{{cantprov()}}</span>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('proveedores') }}"><i class="fa fa-circle-o"></i> Listado de Proveedores</a></li>
    </ul>
</li>

<li class="treeview {{ Route::currentRouteName() == 'materiales.index' ? 'active':null}}">
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

