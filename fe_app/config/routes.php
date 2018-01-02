<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'general/dashboard';

// Inicio
$route['login'] = 'usuario/login';
$route['logout'] = 'usuario/logout';

//Dashboard
$route['dashboard'] = 'general/dashboard';

//Clientes
$route['clientes'] = 'cliente/index';
$route['clientes/ver-cliente/(:num)'] = 'cliente/verCliente/$1';
$route['clientes/agregar-cliente'] = 'cliente/agregarCliente';
$route['clientes/editar-cliente/(:num)'] = 'cliente/editarCliente/$1';
$route['clientes/remover-cliente/(:num)'] = 'cliente/removerCliente/$1';

//Proveedores
$route['facturas'] = 'factura/index';
$route['facturas/agregar-factura'] = 'factura/agregarFactura';
$route['facturas/ver-factura/(:num)'] = 'factura/verFactura/$1';
$route['facturas/editar-factura/(:num)'] = 'factura/editarFactura/$1';
$route['facturas/remover-factura/(:num)'] = 'factura/removerFactura/$1';


//Proyectos
$route['proyectos'] = 'proyecto/index';
$route['proyectos/agregar-proyecto'] = 'proyecto/agregarProyecto';
$route['proyectos/ver-proyecto/(:num)'] = 'proyecto/verProyecto/$1';
$route['proyectos/editar-proyecto/(:num)'] = 'proyecto/editarProyecto/$1';
$route['proyectos/remover-proyecto/(:num)'] = 'proyecto/removerProyecto/$1';
$route['proyectos/extensiones/(:num)'] = 'proyecto/verExtensionesProyecto/$1';
$route['proyectos/extensiones/(:num)/agregar-extension'] = 'proyecto/agregarExtensionProyecto/$1';
$route['proyectos/extensiones/(:num)/editar-extension/(:num)'] = 'proyecto/editarExtensionProyecto/$1/$2';
$route['proyectos/gastos/(:num)'] = 'proyecto/verGastosProyecto/$1';
$route['proyectos/gastos/(:num)/agregar-gasto'] = 'proyecto/agregarGastoProyecto/$1/';
$route['proyectos/gastos/(:num)/editar-gasto/(:num)'] = 'proyecto/editarGastoProyecto/$1/$2';


//Reportes
$route['reportes'] = 'reporte/index';
$route['reportes/proyecto-especifico'] = 'reporte/reporteProyectoEspecifico';
$route['reportes/proyecto-especifico/(:num)'] = 'reporte/generarReporteProyectoEspecifico/$1';

//$route['registro-admin'] = 'usuario/registro_admin';

//Errores
$route['acceso-denegado'] = 'general/errorPermisoDenegado';