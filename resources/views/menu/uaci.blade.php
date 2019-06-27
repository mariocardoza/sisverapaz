<li class="treeview">
    <a href="#">
        <i class="fa fa-line-chart"></i> <span>Plan anual de compras</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{ url('paacs')}}"><i class="fa fa-circle-o"></i> listado de plan anual</a></li>
        <li><a href="{{ url('paacs/crear')}}"><i class="fa fa-circle-o"></i> Registro de plan anual</a></li>
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
        <li><a href="{{url('presupuestos')}}"><i class="fa fa-circle-o"></i> Ver presupuesto</a></li>
        <li><a href="{{url('presupuestos/create')}}"><i class="fa fa-circle-o"></i> Registrar presupuesto</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-bar-chart"></i>
        <span>Requisicion</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('requisiciones')}}"><i class="fa fa-circle-o"></i> Ver requisiciones</a></li>
        <li><a href="{{url('requisiciones/create')}}"><i class="fa fa-circle-o"></i> Registrar requisiciones</a></li>
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
<li class="treeview">
    <a href="#">
        <i class="glyphicon glyphicon-duplicate"></i>
        <span>Contratos</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('contratos') }}"><i class="fa fa-circle-o"></i> Listado de Contratos</a></li>
        <li><a href="{{ url('contratos/create') }}"><i class="fa fa-circle-o"></i> Registro del Contrato</a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Tipos de contratos</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('tipocontratos?dato=1') }}"><i class="fa fa-circle-o"></i> Tipos de contratos</a></li>
        <li><a href="{{ url('tipocontratos/create') }}"><i class="fa fa-circle-o"></i> Registro de Tipo contratos</a></li>
    </ul>
</li>
