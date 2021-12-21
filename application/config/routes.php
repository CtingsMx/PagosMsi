<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'stripe';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



# Yay! Estudio: Redefininedo las rutas del front-end para evitar que contengan /plados al inicio.
$route['/'] = 'plados/index';
$route['nosotros'] = 'plados/nosotros';
$route['soporte'] = 'plados/soporte';
$route['tecnologia'] = 'plados/tecnologia';
$route['productos'] = 'plados/productos';
$route['detalle_articulo/68'] = 'plados/productos';
$route['detalle_articulo/(:any)'] = 'plados/detalle_articulo';
$route['carrito'] = 'plados/carrito';
//$route['agregar_carritoP/(:any)'] = 'plados/agregar_carritoP';
$route['eliminar_art'] = 'plados/eliminar_art';
$route['datos_cliente'] = 'plados/datos_cliente';
$route['guardar_datos'] = 'plados/guardar_datos';
$route['checkout'] = 'stripe/checkoutMsi';
$route['datos_factura'] = 'plados/datos_factura';
$route['revisaDatos'] = 'stripe/revisaDatos';
$route['confirmarPago'] = 'stripe/confirmarPago';
$route['exito/(:any)'] = 'plados/exito';
$route['editarCantidad'] = 'plados/editarCantidad';
$route['puntos-de-venta'] = 'plados/puntosVenta';
$route['contacto'] = 'plados/contacto';


# Rutas para despliegue de promociones:
$route['promos/backup-prices'] = 'plados/backupPrices';
$route['promos/apply-promo/2a69eac9-b3fb-4cf9-a71c-04f5fdd84ed2'] = 'plados/applyPromo';
$route['promos/remove-promo/2a69eac9-b3fb-4cf9-a71c-04f5fdd84ed2'] = 'plados/removePromo';
