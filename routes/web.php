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
    $users = \App\User::all()->count();
    $roles = \App\Role::all();
    if ($users == 0) {
      return view('auth/register', compact('roles'));
    } else {
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
//rutas para autorizaciones del administrador
Route::Post('autorizacion', 'Homecontroller@autorizacion');


///////////  RUTAS DE RESPALDO Y RESTAURAR BASE DE DATOS
Route::get('backups','BackupController@index')->name('backups.index');
Route::get('backups/create','BackupController@create')->name('backup.create');
Route::get('backups/descargar/{file_name}','BackupController@descargar');
Route::get('backups/eliminar/{file_name}', 'BackupController@eliminar');
Route::get('backups/restaurar/{file_name}', 'BackupController@restaurar');

//CONFIGURACIONES DE LA ALCALDIA
Route::get('rentas','RentaController@index')->name('rentas.index');
Route::put('rentas/{id}','RentaController@update')->name('rentas.update');
Route::get('configuraciones','ConfiguracionController@create')->name('configuraciones.create');
Route::post('configuraciones/porcentajes','ConfiguracionController@porcentajes')->name('configuraciones.porcentajes');
Route::post('configuraciones/retenciones','ConfiguracionController@retenciones')->name('configuraciones.retenciones');
Route::post('configuraciones/limites','ConfiguracionController@limitesproyecto')->name('configuraciones.limites');
Route::post('configuraciones/alcaldia','ConfiguracionController@alcaldia')->name('configuraciones.alcaldia');
Route::put('configuraciones/ualcaldia/{configuracione}','ConfiguracionController@ualcaldia')->name('configuraciones.ualcaldia');
Route::put('configuraciones/ulimites/{configuracione}','ConfiguracionController@ulimitesproyecto')->name('configuraciones.ulimites');
Route::post('configuraciones/alcalde','ConfiguracionController@alcalde')->name('configuraciones.alcalde');
Route::put('configuraciones/ualcalde/{configuracione}','ConfiguracionController@ualcalde')->name('configuraciones.ualcalde');
Route::post('configuraciones/logo/{id}','ConfiguracionController@logo')->name('configuraciones.logo');
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
Route::post('giros/baja/{id}','GiroController@baja')->name('giros.baja');
Route::post('giros/alta/{id}','GiroController@alta')->name('giros.alta');
Route::Resource('giros','GiroController');
Route::post('proveedores/representante/{id}','ProveedorController@representante');

Route::post('especialistas/baja/{id}','EspecialistaController@baja')->name('especialistas.baja');
Route::post('especialistas/alta/{id}','EspecialistaController@alta')->name('especialistas.alta');
Route::Resource('especialistas','EspecialistaController');

Route::post('contratos/baja/{id}','ContratoController@alta')->name('contratos.alta');
Route::post('contratos/alta/{id}','ContratoController@baja')->name('contratos.baja');
Route::get('contratos/listarempleados','ContratoController@listarEmpleados');
Route::get('contratos/listartipos','ContratoController@listarTipos');
Route::get('contratos/listarcargos','ContratoController@listarCargos');
Route::post('contratos/guardartipo','ContratoController@guardarTipo');
Route::post('contratos/guardarcargo','ContratoController@guardarCargo');
Route::Resource('contratos','ContratoController');

Route::post('catcargos/baja/{id}','CatCargoController@baja')->name('catcargos.baja');
Route::post('catcargos/alta/{id}','CatCargoController@alta')->name('catcargos.alta');
Route::Resource('catcargos','CatCargoController');

Route::post('contratosuministros/baja{id}','ContratoSuministroController@baja')->name('contratosuministros.baja');
Route::post('contratosuministros/alta/{id}','ContratoSuministroController@alta')->name('contratosuministros.alta');
Route::Resource('contratosuministros','ContratoSuministroController');

Route::get('contratoproyectos/bajar/{archivo}','ContratoproyectoController@bajar');

Route::post('proyectos/baja/{id}','ProyectoController@baja')->name('proyectos.baja');
Route::post('proyectos/alta/{id}','ProyectoController@alta')->name('proyectos.alta');
Route::get('proyectos/listarfondos','ProyectoController@listarFondos');
Route::post('proyectos/guardarcategoria','ProyectoController@guardarCategoria');
Route::delete('proyectos/deleteMonto/{id}','ProyectoController@deleteMonto');
//rutas de las sesiones para los montos de los proyectos
Route::post('proyectos/sesion','ProyectoController@sesion');
Route::get('proyectos/getsesion','ProyectoController@getsesion');
Route::get('proyectos/limpiarsesion','ProyectoController@limpiarsesion');
//nueva forma
Route::get('proyectos/borrarlicitacion/{id}','ProyectoController@borrarlicitacion');
Route::get('proyectos/bajarlicitacion/{archivo}','ProyectoController@bajarlicitacion');
Route::get('proyectos/bajarbase/{archivo}','ProyectoController@bajarbase');
Route::get('proyectos/calendario/{id}','ProyectoController@calendario');
Route::get('proyectos/licitaciones/{id}','ProyectoController@licitacion');
Route::get('proyectos/portipo/{tipo}','ProyectoController@portipo');
Route::get('proyectos/poranio/{anio}','ProyectoController@poranio');
Route::put('proyectos/cambiarestado/{anio}','ProyectoController@cambiarestado');
Route::get('proyectos/informacion/{id}','ProyectoController@informacion');
Route::get('proyectos/solicitudes/{id}','ProyectoController@solicitudes');
Route::get('proyectos/contratos/{id}','ProyectoController@contratos');
Route::get('proyectos/empleados/{id}','ProyectoController@empleados');
Route::get('proyectos/pagos/{id}','ProyectoController@pagos');
Route::get('proyectos/planilla/{id}','ProyectoController@planilla');
Route::post('proyectos/subircontrato','ProyectoController@subircontrato');
Route::post('proyectos/subiroferta','ProyectoController@subiroferta');
Route::post('proyectos/subirbase','ProyectoController@subirbase');
Route::post('proyectos/subiracta','ProyectoController@subiracta');
Route::get('proyectos/elpresupuesto/{id}','ProyectoController@elpresupuesto');
Route::get('proyectos/versolicitud/{id}','ProyectoController@versolicitud');
Route::get('proyectos/formulariosoli/{id}','ProyectoController@formulariosoli');
Route::get('proyectos/generarplanilla/{id}/{idd}','ProyectoController@generar_planilla');
Route::post('proyectos/guardarplanilla','ProyectoController@guardarplanilla');
Route::post('proyectos/quitarempleado','ProyectoController@quitarempleado');
Route::get('proyectos/presupuesto_categoria/{id}/{idproy}','ProyectoController@presupuesto_categoria');
//rutas resource para proyectos
Route::Resource('proyectos','ProyectoController');
Route::Resource('jornadas','JornadaController');
Route::Resource('cargoproyectos','CargoproyectoController');

Route::Resource('indicadores','IndicadoresController');
Route::get('indicadores/segunproyecto/{id}','IndicadoresController@segunproyecto');
Route::post('indicadores/completado','IndicadoresController@completado');

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
Route::get('ordencompras/modal_registrar/{id}','OrdencompraController@modal_registrar');
Route::Resource('ordencompras','OrdencompraController');

Route::get('presupuestos/crear','PresupuestoController@crear');
Route::get('presupuestos/seleccionaritem/{id}','PresupuestoController@seleccionaritem');
Route::get('presupuestos/getcategorias/{id}','PresupuestoController@getCategorias');
Route::get('presupuestos/getcatalogo/{id}/{idd}','PresupuestoController@getCatalogo');
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

Route::Resource('materiales','MaterialesController');
Route::get('materiales/modaleditar/{id}','MaterialesController@modaleditar');
Route::post('materiales/baja/{id}','MaterialesController@baja')->name('materiales.baja');
Route::post('materiales/alta/{id}','MaterialesController@alta')->name('materiales.alta');



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
Route::get('paacs/exportar/{id}','PaacController@exportar');
Route::get('paacs/show2/{id}','PaacController@show2');
Route::Resource('paacs','PaacController');
Route::post('paaccategorias/baja/{id}','PaacCategoriaController@baja')->name('paaccategorias.baja');
Route::post('paaccategorias/alta/{id}','PaacCategoriaController@alta')->name('paaccategorias.alta');

Route::Resource('paaccategorias','PaacCategoriaController');
Route::Resource('paacdetalles','PaacdetalleController');

Route::Resource('detallecotizaciones','DetallecotizacionController');

Route::post('formapagos/baja/{id}','FormapagoController@baja')->name('formapagos.baja');
Route::post('formapagos/alta/{id}','FormapagoController@alta')->name('formapagos.alta');
Route::Resource('formapagos','FormapagoController');

Route::post('solicitudcotizaciones/baja/{id}','SolicitudcotizacionController@baja')->name('solicitudcotizaciones.baja');
Route::post('solicitudcotizaciones/alta/{id}','SolicitudcotizacionController@alta')->name('solicitudcotizaciones.alta');
Route::get('solicitudcotizaciones/versolicitudes/{id}','SolicitudcotizacionController@versolicitudes');
Route::get('solicitudcotizaciones/modal_cotizacion/{id}','SolicitudcotizacionController@modal_cotizacion');
Route::get('solicitudcotizaciones/getcategorias','SolicitudcotizacionController@getCategorias');
Route::get('solicitudcotizaciones/getpresupuesto','SolicitudcotizacionController@getPresupuesto');
Route::post('solicitudcotizaciones/cambiar','SolicitudcotizacionController@cambiar');
Route::get('solicitudcotizaciones/create/{id}','SolicitudcotizacionController@create');
Route::get('solicitudcotizaciones/creater/{id}','SolicitudcotizacionController@creater');
Route::post('solicitudcotizaciones/storer','SolicitudcotizacionController@storer');
Route::Resource('solicitudcotizaciones','SolicitudcotizacionController');

Route::Resource('contratorequisiciones','ContratoRequisicionController');
Route::get('contratorequisiciones/bajar/{archivo}','ContratoRequisicionController@bajar');

Route::get('requisiciones/porusuario','RequisicionController@porusuario')->name('requisiciones.porusuario');
Route::post('requisiciones/darbaja','RequisicionController@darbaja');
Route::get('requisiciones/portipo/{tipo}','RequisicionController@portipo');
Route::get('requisiciones/poranio/{anio}','RequisicionController@poranio');
Route::get('requisiciones/informacion/{id}','RequisicionController@informacion');
Route::post('requisiciones/aprobar','RequisicionController@aprobar');
Route::get('requisiciones/mostrarcontrato/{id}','RequisicionController@mostrar_contrato');
Route::post('requisiciones/subir','RequisicionController@subir');
Route::post('requisiciones/subircontrato','RequisicionController@subircontrato');
Route::get('requisiciones/bajar/{archivo}','RequisicionController@bajar');
Route::put('requisiciones/cambiarestado/{id}','RequisicionController@cambiarestado');
Route::get('requisiciones/materiales/{id}','RequisicionController@materiales');
Route::get('requisiciones/presupuesto/{id}','RequisicionController@presupuesto');
Route::post('requisiciones/modalagregar','RequisicionController@modal_agregarproducto');
Route::get('requisiciones/vercotizacion/{id}','RequisicionController@ver_cotizacion');
Route::get('requisiciones/versolicitud/{id}','RequisicionController@ver_solicitud');
Route::get('requisiciones/formulariosoli/{id}','RequisicionController@formulariosoli');
Route::Resource('requisiciones','RequisicionController');
Route::get('requisiciondetalles/create/{id}','RequisiciondetalleController@create');
Route::post('requisiciondetalles/guardar','RequisiciondetalleController@guardar');
Route::Resource('requisiciondetalles','RequisiciondetalleController');

Route::Resource('organizaciones','OrganizacionController');
Route::Resource('calendarizaciones','CalendarizacionController');
Route::get('inventarios/getmaterial/{id}','ProyectoInventarioController@getMaterial');
Route::Resource('inventarios','ProyectoInventarioController');

Route::Resource('categoriatrabajos','CategoriaTrabajoController');
Route::get('categoriatrabajos/create','CategoriaTrabajoController@create');
Route::post('categoriatrabajos/baja/{id}','CategoriaTrabajoController@baja')->name('categoriatrabajos.baja');
Route::post('categoriatrabajos/alta/{id}','CategoriaTrabajoController@alta')->name('categoriatrabajos.alta');

Route::Resource('categoriaempleados','CategoriaEmpleadoController');
Route::get('categoriaempleados/create/{id}','CategoriaEmpleadoController@create');
Route::post('categoriaempleados/baja/{id}','CategoriaEmpleadoController@baja')->name('categoriaempleados.baja');
Route::post('categoriaempleados/alta/{id}','CategoriaEmpleadoController@alta')->name('categoriaempleados.alta');
Route::get('categoriaempleados/listarempleados/{id}','CategoriaEmpleadoController@listarEmpleados');
Route::get('categoriaempleados/listarempleados/{id}','CategoriaEmpleadoController@listarEmpleados');

////////////////triburario /////////////////////////////////////////////////////////////////////////
/*Route::post('contribuyentes/baja/{id}','ContribuyenteController@baja')->name('contribuyentes.baja');
Route::post('contribuyentes/alta/{id}','ContribuyenteController@alta')->name('contribuyentes.alta');
Route::get('contribuyentes/eliminados','ContribuyenteController@eliminados');*/
Route::Resource('contribuyentes','ContribuyenteController');

Route::Resource('tiposervicios','TiposervicioController');
/*Route::post('impuestos/baja/{id}','impuestoController@baja')->name('impuestos.baja');
Route::post('impuestos/alta/{id}','ImpuestoController@alta')->name('impuestos.alta');
Route::Resource('impuestos','ImpuestoController');*/

Route::post('rubros/baja/{id}','RubroController@baja')->name('rubros.baja');
Route::post('rubros/alta/{id}','RubroController@alta')->name('rubros.alta');
Route::Resource('rubros','RubroController');

Route::Resource('negocios','NegocioController');

/*Route::post('inmuebles/baja/{id}','InmuebleController@baja')->name('inmuebles.baja');
Route::post('inmuebles/alta/{id}','InmuebleController@alta')->name('inmuebles.alta');
Route::Resource('inmuebles','InmuebleController');*/

Route::Resource('construcciones','ConstruccionController');

////////// Tesoreria //////////////////////////////////
Route::Resource('empleados','EmpleadoController');
Route::get('empleados/selectcargos/{id}','EmpleadoController@selectcargo');
Route::post('empleados/bancarios','EmpleadoController@bancarios');
Route::post('empleados/afps','EmpleadoController@afps');
Route::post('empleados/isss','EmpleadoController@isss');
Route::post('empleados/usuarios','EmpleadoController@usuarios');
Route::post('empleados/eusuarios','EmpleadoController@eusuarios');
Route::post('empleados/foto/{id}','EmpleadoController@foto');

Route::Resource('afps','AfpController');

Route::get('servicios/pagos','ServiciosController@pagos');
Route::post('servicios/pagar','ServiciosController@pagar_servicio');
Route::Resource('servicios','ServiciosController');

Route::Resource('retenciones','RetencionController');

Route::post('planillas/pagar','PlanillaController@pagar');
Route::Resource('planillas','PlanillaController');
Route::get('planillaproyectos/cambiarestado/{id}','PeriodoProyectoController@cambiarestado');
Route::get('planillaproyectos/desembolso/{id}','PeriodoProyectoController@desembolso');
Route::Resource('planillaproyectos','PeriodoProyectoController');

Route::get('pagocuentas/{id}','PagocuentaController@index')->name("pagocuentas.index");

Route::Resource('pagorentas','PagoRentaController');

Route::Resource('prestamos','PrestamoController');
Route::Resource('descuentos','DescuentoController');

Route::post('prestamotipos/baja/{id}','PrestamotiposController@baja')->name('prestamotipos.baja');
Route::Resource('prestamotipos','PrestamotiposController');

Route::get('cargos/get','CargoController@get');
Route::Resource('cargos','CargoController');
Route::post('cargos/baja/{id}','CargoController@baja')->name('cargos.baja');
Route::post('cargos/alta/{id}','CargoController@alta')->name('cargos.alta');

Route::get('cuentas/get','CuentaController@get');
Route::get('cuentas/proyectos','CuentaController@proyectos');
Route::put('cuentas/editarproyectos/{id}','CuentaController@editarproyectos');
Route::get('cuentas/movimientos/{id}','CuentaController@show2');
Route::get('cuentas/modalasignar/{id}/{tipo}','CuentaController@modal_asignar');
Route::get('cuentas/modalremesar/{id}/{tipo}','CuentaController@modal_remesar');
Route::post('cuentas/abonarcuenta','CuentaController@abonarcuenta');
Route::post('cuentas/abonarproyecto','CuentaController@abonarproyecto');
Route::post('cuentas/remesarcuenta','CuentaController@remesarcuenta');
Route::post('cuentas/remesarproyecto','CuentaController@remesarproyecto');
Route::Resource('cuentas','CuentaController');

//Route::Resource('cuentaprincipal','CuentaprincipalController');
Route::post('cuentas/baja{id}','CuentaController@baja')->name('cuentas.baja');
Route::post('cuentas/alta/{id}','CuentaController@alta')->name('cuentas.alta');

Route::Resource('desembolsos','DesembolsoController');

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

Route::get('reportesuaci/requisicionobra/{id}','ReportesUaciController@requisicionobra');
Route::get('reportesuaci/acta/{id}','ReportesUaciController@acta');
Route::get('reportesuaci/cotizaciones/{id}','ReportesUaciController@cotizaciones');

Route::get('reportesuaci/presupuestounidad/{id}','ReportesUaciController@presupuestounidad');
Route::get('reportesuaci/planillaproyecto/{id}','ReportesUaciController@planillaproyecto');
Route::get('reportesuaci/asistenciaproyecto/{id}','ReportesUaciController@asistenciaproyecto');

//Reportes Tesoreria
Route::get('reportestesoreria/pagos/{id}','ReportesTesoreriaController@pagos');///////////REVISAR
Route::get('reportestesoreria/planillas/{id}','ReportesTesoreriaController@planillas');
Route::get('reportestesoreria/planillas2/{id}','ReportesTesoreriaController@planillas2');

Route::get('reportestesoreria/planillaaprobada/{id}','ReportesTesoreriaController@planillaaprobada');
Route::get('reportestesoreria/boleta/{id}','ReportesTesoreriaController@boleta');

Route::get('reportestesoreria/pagorenta/{id}','ReportesTesoreriaController@pagorentas');

//Ruta para detalle de planillas
Route::Resource('detalleplanillas','DetalleplanillaController');
Route::Resource('bancos','BancoController');
Route::post('bancos/baja/{id}','BancoController@baja')->name('bancos.baja');
Route::post('bancos/alta/{id}','BancoController@alta')->name('bancos.alta');
Route::Resource('vacaciones','VacacionController');
Route::post('vacaciones/fecha','VacacionController@fecha');

//Rutas R
Route::get('categoria/listar','SolicitudcotizacionController@categorias_ne')->name('categoria.listar');











































Route::Resource('unidades','UnidadAdminController');
Route::get('presupuestounidades/materiales/{id}','PresupuestoUnidadController@materiales');
Route::get('presupuestounidades/anio/{anio}','PresupuestoUnidadController@anio');
Route::post('presupuestounidades/cambiar/{id}','PresupuestoUnidadController@cambiar');
Route::get('presupuestounidades/clonar/{id}','PresupuestoUnidadController@clonar');
Route::get('presupuestounidades/porunidad','PresupuestoUnidadController@porunidad')->name('presupuestounidades.porunidad');
Route::Resource('presupuestounidades','PresupuestoUnidadController');
Route::Resource('presupuestounidaddetalles','PresupuestoUnidadDetalleController');



/**
 * Rutas para el mapa
*/

Route::get('negocio/mapa/{id}', 'NegocioController@viewMapa');
Route::post('negocio/mapa/create', 'NegocioController@mapas');
Route::get('mapa', 'NegocioController@mapa');
Route::post('mapa/all', 'NegocioController@mapasAll');
Route::get('reporte', 'ReportesUaciController@reportePDF');

// Routas para el cementerio
Route::Resource("/cementerios", "CementerioController");