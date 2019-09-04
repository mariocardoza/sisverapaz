<li class="treeview">
    <a href="#">
        <i class="fa fa-edit"></i> <span>Cuenta principal</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{ url('cuentaprincipal') }}"><i class="fa fa-circle-o"></i> Listado de cuentas</a></li>
        
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


