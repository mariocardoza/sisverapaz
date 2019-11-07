<li class="treeview {{ Route::currentRouteName() == 'cuentas.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Cuentas</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('cuentas') }}"><i class="fa fa-circle-o"></i> Listado de cuentas</a></li>
        
    </ul>
</li>

<li class="treeview {{ Route::currentRouteName() == 'desembolsos.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Egresos</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('desembolsos') }}"><i class="fa fa-circle-o"></i> Egresos </a></li>
        
    </ul>
</li>

<li class="treeview {{ Route::currentRouteName() == 'empleados.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Empleados</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('empleados') }}"><i class="fa fa-circle-o"></i> Listado de empleados</a></li>
        
    </ul>
</li>

<li class="treeview {{ Route::currentRouteName() == 'planillas.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Planillas</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('planillas') }}"><i class="fa fa-circle-o"></i> Planillas </a></li>
        
    </ul>
</li>

<li class="treeview {{ Route::currentRouteName() == 'pagocuentas.index' ? 'active':null}}">
        <a href="#">
            <i class="fa fa-edit"></i> <span>Pago a cuenta</span>
            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ url('pagocuentas') }}"><i class="fa fa-circle-o"></i> pagos </a></li>
            
        </ul>
    </li>

<li class="treeview {{ Route::currentRouteName() == 'planillaproyectos.index' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Pagos a proyectos</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('planillaproyectos') }}"><i class="fa fa-circle-o"></i> Planilla de proyectos </a></li>
        
    </ul>
</li>

<li class="treeview {{ Route::currentRouteName() == 'presupuestounidades.porunidad' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Presupuestos</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('presupuestounidades/porunidad') }}"><i class="fa fa-circle-o"></i> Mis presupuestos</a></li>
        
    </ul>
</li>

<li class="treeview {{ Route::currentRouteName() == 'requisiciones.porusuario' ? 'active':null}}">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Requisiciones</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('requisiciones/porusuario') }}"><i class="fa fa-circle-o"></i> Mis requisiciones</a></li>
        
    </ul>
</li>


