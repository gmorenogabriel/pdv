<?php

use CodeIgniter\Router\RouteCollection;


 /* --------------------------------------------------------------------
 * Router Setup viene de versiones anteriores
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('App\Controllers\Usuarios');
//$routes->setDefaultController('Inicio');
//$routes->setDefaultController('App\Controllers\Front\Home');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/**
 * @var RouteCollection $routes
 *
 *  Ruta principal que viene por defecto
   $routes->get('/', 'Home::index');
 */

$routes->group('/',['namespace' => 'App\Controllers'],function($routes){
        $routes->get('login',            'Usuarios::login',    ['as' => 'usuarios']);   // Web de Ingreso http://localhost:8084/pdv/public/login
        $routes->post('usuarios/valida', 'Usuarios::valida',   ['as' => 'valida']);
        $routes->get('inicio',           'Inicio::index',      ['as' => 'inicio']);
        $routes->get('productos',        'Productos::index',   ['as' => 'productos']);
        $routes->get('unidades',         'Unidades::index',   ['as' => 'unidades']);		
        $routes->get('categorias',       'Categorias::index',   ['as' => 'categorias']);				
        $routes->get('clientes',         'Clientes::index',    ['as' => 'clientes']);		
        $routes->get('compras',          'Compras::index',     ['as' => 'compras']);				
        $routes->get('compras/nuevo',    'Compras::nuevo',     ['as' => 'comprasnuevo']);	
		$routes->get('datatables',       'Datatables::index',  ['as' => 'datatables']);	
		$routes->get('configuracion',    'Configuracion::index',  ['as' => 'configuracion']);			
		$routes->get('monedas',          'Monedas::index',  ['as' => 'monedas']);
        $routes->get('usuarios/nuevo',   'Usuarios::nuevo',   ['as' => 'usuariosnuevo']);		
		$routes->get('menus',            'Menus::index',  ['as' => 'menus']);					
		$routes->get('roles',            'Roles::index',  ['as' => 'roles']);					
		$routes->get('permisos',         'Permisos::index',  ['as' => 'permisos']);			
        $routes->get('envioemail',       'EnvioEMail::index',   ['as' => 'envioemail']);	
	//	$routes->get('graficastock',    'Productos::graficastockMinimoProductos',     ['as' => 'graficastockminprod']);
		$routes->get('graficacompras',    'Compras::graficacompras',     ['as' => 'graficacompras']);
});
