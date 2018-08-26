<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $users=\App\User::all()->count();
    $roles = \App\Role::all();
        if($users==0){
            return view('auth/register',compact('roles'));

        }else{
            return view('auth/login');
        }
});

Route::get('pdf',function(){
  $usuarios = \App\Proveedor::where('estado',1)->get();
  $unidad = "Unidad de Adquicisiones Institucionales";
  $pdf = \PDF::loadView('pdf.pdf',compact('usuarios','unidad'));
  $pdf->setPaper('letter', 'portrait');
  //$canvas = $pdf ->get_canvas();
//$canvas->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
  return $pdf->stream('reporte.pdf');
});

///////////  RUTAS DE RESPALDO Y RESTAURAR BASE DE DATOS
Route::get('backups','BackupController@index');
Route::get('backups/create','BackupController@create')->name('backup.create');
Route::get('backups/descargar/{file_name}','BackupController@descargar');
Route::get('backups/eliminar/{file_name}', 'BackupController@eliminar');
Route::get('backups/restaurar/{file_name}', 'BackupController@restaurar');

//CONFIGURACIONES DE LA ALCALDIA
Route::get('configuraciones','ConfiguracionController@create');
Route::post('configuraciones/alcaldia','ConfiguracionController@alcaldia')->name('configuraciones.alcaldia');
Route::put('configuraciones/ualcaldia/{configuracione}','ConfiguracionController@ualcaldia')->name('configuraciones.ualcaldia');
Route::post('configuraciones/alcalde','ConfiguracionController@alcalde')->name('configuraciones.alcalde');
Route::put('configuraciones/ualcalde/{configuracione}','ConfiguracionController@ualcalde')->name('configuraciones.ualcalde');
Route::post('configuraciones/logo','ConfiguracionController@logo')->name('configuraciones.logo');
Auth::routes();

Route::post('authenticate','Auth\loginController@authenticate')->name('authenticate');

Route::get('/home', 'HomeController@index')->name('home');
//administrador
Route::post('usuarios/baja/{id}','UsuarioController@baja')->name('usuarios.baja');
Route::post('usuarios/alta/{id}','UsuarioController@alta')->name('usuarios.alta');
Route::Resource('usuarios','UsuarioController');

//Route::Resource('bitacoras' , 'BitacoraController');
Route::get('bitacoras','BitacoraController@index');
Route::get('bitacoras/general','BitacoraController@general');
Route::get('bitacoras/usuario','BitacoraController@usuario');
Route::get('bitacoras/fecha','BitacoraController@fecha');

//Perfil de usuario
route::get('home/perfil','UsuarioController@perfil');
route::get('perfil/{id}','UsuarioController@modificarperfil');
Route::put('updateperfil','UsuarioController@updateperfil');
Route::get('avatar','UsuarioController@avatar');
Route::post('usuarios/updateprofile', 'UsuarioController@actualizaravatar');


//////////////////////////////////// UACI /////////////////////////////////////////////////////
Route::post('proveedores/baja/{id}','ProveedorController@baja')->name('proveedores.baja');
Route::post('proveedores/alta/{id}','ProveedorController@alta')->name('proveedores.alta');
Route::Resource('proveedores','ProveedorController');

Route::post('contratos/baja/{id}','ContratoController@alta')->name('contratos.alta');
Route::post('contratos/alta/{id}','ContratoController@baja')->name('contratos.baja');
Route::get('contratos/listarempleados','ContratoController@listarEmpleados');
Route::get('contratos/listartipos','ContratoController@listarTipos');
Route::get('contratos/listarcargos','ContratoController@listarCargos');
Route::post('contratos/guardartipo','ContratoController@guardarTipo');
Route::post('contratos/guardarcargo','ContratoController@guardarCargo');
Route::Resource('contratos','ContratoController');

Route::get('contratacionproyectos/listadeempleados/{id}','EPContratacionController@listadeempleados');
Route::get('contratacionproyectos/todos','EPContratacionController@todosloscontratos');
Route::get('contratacionproyectos/create/{id}','EPContratacionController@create');
Route::get('contratacionproyectos/vercontratado/{id}','EPContratacionController@vercontratado');
Route::Resource('contratacionproyectos','EPContratacionController');

Route::post('contratoproyectos/baja/{id}','ContratoproyectoController@baja')->name('contratoproyectos.baja');
Route::post('contratoproyectos/alta/{id}','ContratoproyectoController@alta')->name('contratoproyectos.alta');
Route::Resource('contratoproyectos','ContratoproyectoController');

Route::post('contratosuministros/baja{id}','ContratoSuministroController@baja')->name('contratosuministros.baja');
Route::post('contratosuministros/alta/{id}','ContratoSuministroController@alta')->name('contratosuministros.alta');
Route::Resource('contratosuministros','ContratoSuministroController');

Route::post('proyectos/baja/{id}','ProyectoController@baja')->name('proyectos.baja');
Route::post('proyectos/alta/{id}','ProyectoController@alta')->name('proyectos.alta');
Route::get('proyectos/listarfondos','ProyectoController@listarFondos');
Route::post('proyectos/guardarcategoria','ProyectoController@guardarCategoria');
Route::delete('proyectos/deleteMonto/{id}','ProyectoController@deleteMonto');
//rutas de las sesiones para los montos de los proyectos
Route::post('proyectos/sesion','ProyectoController@sesion');
Route::get('proyectos/getsesion','ProyectoController@getsesion');
Route::get('proyectos/limpiarsesion','ProyectoController@limpiarsesion');
//rutas resource para proyectos
Route::Resource('proyectos','ProyectoController');

Route::post('fondocats/baja/{id}','FondocatController@baja')->name('fondocats.baja');
Route::post('fondocats/alta/{id}','FondocatController@alta')->name('fondocats.alta');
Route::Resource('fondocats','FondocatController');

Route::post('tipocontratos/baja/{id}','TipocontratoController@baja')->name('tipocontratos.baja');
Route::post('tipocontratos/alta/{id}','TipocontratoController@alta')->name('tipocontratos.alta');
Route::Resource('tipocontratos','TipocontratoController');

Route::post('ordencompras/baja/{id}','OrdencompraController@baja')->name('ordencompras.baja');
Route::post('ordencompras/alta/{id}','OrdencompraController@alta')->name('ordencompras.alta');
Route::get('ordencompras/cotizaciones/{id}','OrdencompraController@getCotizacion');
Route::get('ordencompras/montos/{id}','OrdencompraController@getMonto');
Route::get('ordencompras/realizarorden/{id}','OrdencompraController@realizarorden');
Route::get('ordencompras/verificar/{id}','OrdencompraController@verificar');
Route::post('ordencompras/guardar','OrdencompraController@guardar')->name('ordencompras.guardar');
Route::get('ordencompras/requisiciones','OrdencompraController@requisiciones');
Route::get('ordencompras/create/{id}','OrdencompraController@create');
Route::Resource('ordencompras','OrdencompraController');

Route::get('presupuestos/crear','PresupuestoController@crear');
Route::get('presupuestos/seleccionaritem/{id}','PresupuestoController@seleccionaritem');
Route::get('presupuestos/getcategorias/{id}','PresupuestoController@getCategorias');
Route::get('presupuestos/getcatalogo/{id}','PresupuestoController@getCatalogo');
Route::get('presupuestos/getunidades','PresupuestoController@getUnidadesMedida');
Route::post('presupuestos/cambiar','PresupuestoController@cambiar')->name('presupuestos.cambiar');
Route::post('presupuestos/guardarsesion','PresupuestoController@guardarsesion');
Route::post('presupuestos/traersesion','PresupuestoController@traersesion');
Route::Resource('presupuestos','PresupuestoController');

Route::get('presupuestodetalles/create/{id}','PresupuestoDetalleController@create');
Route::get('presupuestodetalles/getcatalogo','PresupuestoDetalleController@getCatalogo');
Route::post('presupuestodetalles/guardarsesion','PresupuestoDetalleController@guardarsesion');
Route::get('presupuestodetalles/traersesion','PresupuestoDetalleController@traersesion');
Route::delete('presupuestodetalles/eliminarsesion/{id}','PresupuestoDetalleController@eliminarsesion');
Route::get('presupuestodetalles/limpiarsesion','PresupuestoDetalleController@limpiarsesion');
Route::Resource('presupuestodetalles','PresupuestoDetalleController');

Route::get('catalogos/create','CatalogoController@create');
Route::post('catalogos/guardar','CatalogoController@guardar');
Route::Resource('catalogos','CatalogoController');
Route::post('catalogos/baja/{id}','CatalogoController@baja')->name('catalogos.baja');
Route::post('catalogos/alta/{id}','CatalogoController@alta')->name('catalogos.alta');

Route::get('categorias/create','CategoriaController@create');
Route::post('categorias/guardar','CatalogoController@guardar');
Route::Resource('categorias','CategoriaController');
Route::post('categorias/baja/{id}','CategoriaController@baja')->name('categorias.baja');
Route::post('categorias/alta/{id}','CategoriaController@alta')->name('categorias.alta');

Route::get('unidadmedidas/create','UnidadMedidaController@create');
route::post('unidadmedidas/guardar','UnidadMedidaController@guardar');
Route::Resource('unidadmedidas','UnidadMedidaController');
//Route::Resource('unidadmedidas/baja/{id}','UnidadMedidaController@baja')->name('unidadmedidas.baja');
//Route::Resource('unidadmedidas/alta/{id}','UnidadMedidaController@alta')->name('unidadmedidas.alta');

Route::get('cotizaciones/ver/cuadros','CotizacionController@cuadros');
Route::get('cotizaciones/ver/{id}', 'CotizacionController@cotizar');
Route::get('cotizaciones/cotizarr/{id}', 'CotizacionController@cotizarr');
Route::post('cotizaciones/seleccionar','CotizacionController@seleccionar');
Route::post('cotizaciones/seleccionarr','CotizacionController@seleccionarr');
Route::post('cotizaciones/baja/{id}','CotizacionController@baja')->name('cotizaciones.baja');
Route::post('cotizaciones/alta/{id}','CotizacionController@alta')->name('cotizaciones.alta');
Route::get('cotizaciones/realizarcotizacion/{id}','CotizacionController@realizarCotizacion');
Route::get('cotizaciones/realizarcotizacionr/{id}','CotizacionController@realizarCotizacionr');
Route::Resource('cotizaciones','CotizacionController');

Route::get('paacs/crear','PaacController@crear');
route::post('paacs/guardar','PaacController@guardar');
Route::Resource('paacs','PaacController');
Route::Resource('paacdetalles','PaacdetalleController');

Route::Resource('detallecotizaciones','DetallecotizacionController');

Route::post('formapagos/baja/{id}','FormapagoController@baja')->name('formapagos.baja');
Route::post('formapagos/alta/{id}','FormapagoController@alta')->name('formapagos.alta');
Route::Resource('formapagos','FormapagoController');

Route::post('solicitudcotizaciones/baja/{id}','SolicitudcotizacionController@baja')->name('solicitudcotizaciones.baja');
Route::post('solicitudcotizaciones/alta/{id}','SolicitudcotizacionController@alta')->name('solicitudcotizaciones.alta');
Route::get('solicitudcotizaciones/versolicitudes/{id}','SolicitudcotizacionController@versolicitudes');
Route::get('solicitudcotizaciones/getcategorias','SolicitudcotizacionController@getCategorias');
Route::get('solicitudcotizaciones/getpresupuesto','SolicitudcotizacionController@getPresupuesto');
Route::post('solicitudcotizaciones/cambiar','SolicitudcotizacionController@cambiar');
Route::get('solicitudcotizaciones/create/{id}','SolicitudcotizacionController@create');
Route::get('solicitudcotizaciones/creater/{id}','SolicitudcotizacionController@creater');
Route::post('solicitudcotizaciones/storer','SolicitudcotizacionController@storer');
Route::Resource('solicitudcotizaciones','SolicitudcotizacionController');

Route::Resource('requisiciones','RequisicionController');
Route::get('requisiciondetalles/create/{id}','RequisiciondetalleController@create');
Route::Resource('requisiciondetalles','RequisiciondetalleController');

Route::Resource('organizaciones','OrganizacionController');
Route::Resource('calendarizaciones','CalendarizacionController');
Route::get('inventarios/getmaterial/{id}','ProyectoInventarioController@getMaterial');
Route::Resource('inventarios','ProyectoInventarioController');

Route::Resource('categoriatrabajos','CategoriaTrabajoController');
Route::get('categoriatrabajos/create','CategoriaTrabajoController@create');//------------>

Route::Resource('categoriaempleados','CategoriaEmpleadoController');
Route::get('categoriaempleados/create/{id}','CategoriaEmpleadoController@create');
//Route::post('categoriaempleados/baja/{id}','CategoriaEmpleadoController');

////////////////triburario /////////////////////////////////////////////////////////////////////////
Route::post('contribuyentes/baja/{id}','ContribuyenteController@baja')->name('contribuyentes.baja');
Route::post('contribuyentes/alta/{id}','ContribuyenteController@alta')->name('contribuyentes.alta');
Route::get('contribuyentes/eliminados','ContribuyenteController@eliminados');
Route::Resource('contribuyentes','ContribuyenteController');

Route::Resource('tiposervicios','TiposervicioController');
Route::post('impuestos/baja/{id}','impuestoController@baja')->name('impuestos.baja');
Route::post('impuestos/alta/{id}','ImpuestoController@alta')->name('impuestos.alta');
Route::Resource('impuestos','ImpuestoController');

Route::post('rubros/baja/{id}','RubroController@baja')->name('rubros.baja');
Route::post('rubros/alta/{id}','RubroController@alta')->name('rubros.alta');
Route::Resource('rubros','RubroController');

Route::Resource('negocios','NegocioController');

Route::post('inmuebles/baja/{id}','InmuebleController@baja')->name('inmuebles.baja');
Route::post('inmuebles/alta/{id}','InmuebleController@alta')->name('inmuebles.alta');
Route::Resource('inmuebles','InmuebleController');

Route::Resource('construcciones','ConstruccionController');

////////// Tesoreria //////////////////////////////////
Route::Resource('empleados','EmpleadoController');

Route::Resource('retenciones','RetencionController');

Route::Resource('planillas','PlanillaController');
Route::Resource('prestamos','PrestamoController');

Route::get('cargos/get','CargoController@get');
Route::Resource('cargos','CargoController');

Route::Resource('cuentas','CuentaController');
Route::Resource('cuentaprincipal','CuentaprincipalController');

Route::Resource('tipopagos','TipopagoController');

Route::Resource('pagos','PagoController');

Route::Resource('tipopagos', 'TipopagoController');



//Rutas de Reportes UACI
Route::get('reportesuaci/proyectos','ReportesUaciController@proyectos');

Route::get('reportesuaci/proveedores','ReportesUaciController@proveedor');

Route::get('reportesuaci/solicitud/{id}','ReportesUaciController@solicitud');

Route::get('reportesuaci/ordencompra/{id}','ReportesUaciController@ordencompra');

Route::get('reportesuaci/cuadrocomparativo/{id}','ReportesUaciController@cuadrocomparativo');

Route::get('reportesuaci/contratoproyecto/{id}','ReportesUaciController@contratoproyecto');

Route::get('reportesuaci/requisicionobra','ReportesUaciController@requisicionobra');

//Reportes Tesoreria
Route::get('reportestesoreria/pagos/{id}','ReportesTesoreriaController@pagos');









































Route::Resource('unidades','UnidadAdminController');
Route::Resource('presupuestounidades','PresupuestoUnidadController');



/**
 * Rutas para el mapa
*/

Route::get('negocio/mapa/{id}', 'NegocioController@viewMapa');
Route::post('negocio/mapa/create', 'NegocioController@mapas');
Route::get('mapa', 'NegocioController@mapa');
Route::post('mapa/all', 'NegocioController@mapasAll');
