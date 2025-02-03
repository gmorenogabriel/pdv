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
   $routes->get('/', 'Home::index')
 */
 // Define la ruta por defecto para redirigir a Usuarios::login
$routes->get('/', 'Usuarios::login');

$routes->group('/',['namespace' => 'App\Controllers'],function($routes){
        $routes->get('login',            				'Usuarios::login',    			['as' => 'usuarios']);   // Web de Ingreso http://localhost:8084/pdv/public/login
		$routes->get('dash',             				'Dashboard::index',    			['as' => 'dash']); 
        $routes->post('usuarios/valida', 				'Usuarios::valida',   			['as' => 'valida']);
		$routes->get('inicio',           				'Inicio::index',      			['as' => 'inicio']);
        $routes->get('flujocaja',        				'FlujoCaja::index',   			['as' => 'flujocaja']);
		$routes->get('flujocaja/entradas',      		'FlujoCaja::entradas',   		['as' => 'flujocajaentradas']);
		$routes->get('flujocaja/salidas',      			'FlujoCaja::salidas',   		['as' => 'flujocajasalidas']);		
		$routes->post('flujocaja/guardarentrada',        'FlujoCaja::guardarentrada', 	['as' => 'flujocajaguardarentrada']);		
		$routes->post('flujocaja/guardarsalida',         'FlujoCaja::guardarsalida', 	['as' => 'flujocajaguardarsalida']);				
		$routes->get('flujocaja/generaExcel',			'FlujoCaja::generaExcel',   	['as' => 'flujoexcel']);
		$routes->get('flujocaja/generaPdf',				'FlujoCaja::generaPdf',   		['as' => 'flujopdf']);
/*      --------- */		
		$routes->get('productos',        				'Productos::index',   			['as' => 'productos']);
		$routes->get('productos/nuevo',    				'Productos::nuevo',     		['as' => 'productosnuevo']);			
		$routes->get('productos/eliminados',    		'Productos::eliminados',     	['as' => 'productoselim']);	
		$routes->get('productos/generaBarras',			'Productos::generaBarras', 		['as' => 'productosbarras']);
/*      --------- */
		$routes->get('unidades',         				'Unidades::index',   			['as' => 'unidades']);
		$routes->get('unidades/nuevo',    				'Unidades::nuevo',     			['as' => 'unidadesnuevo']);			
		$routes->get('unidades/editar/(:any)',			'Unidades::editar/$1',			['as' => 'unidadesedit']);			
		$routes->post('unidades/actualizar/(:any)',		'Unidades::actualizar/$1',		['as' => 'unidadesactual']);
		$routes->post('unidades/eliminar/(:any)',		'Unidades::actualizar/$1',		['as' => 'unidadesactual']);
		$routes->get('unidades/encode/(:num)', 			'Unidades::encodeData/$1');
		$routes->get('unidades/decode/(:any)', 			'Unidades::decodeData/$1');
		$routes->get('unidades/generaExcel',			'Unidades::generaExcel',   		['as' => 'unidadesexcel']);
		$routes->get('unidades/generaPdf',				'Unidades::generaPdf',   		['as' => 'unidadespdf']);
/*      --------- */
		$routes->get('categorias',       				'Categorias::index',   			['as' => 'categorias']);
		$routes->get('categorias/nuevo',       			'Categorias::nuevo',   			['as' => 'categoriasnuevo']);		
		$routes->get('categorias/eliminados',       	'Categorias::eliminados',   	['as' => 'categoriaselim']);		
		$routes->get('categorias/generaExcel',			'Categorias::generaExcel',  	['as' => 'categexcel']);
		$routes->get('categorias/generaPdf',			'Categorias::generaPdf',   		['as' => 'categpdf']);
/*      --------- */
		$routes->get('clientes',         				'Clientes::index',    			['as' => 'clientes']);		
        $routes->get('compras',          				'Compras::index',     			['as' => 'compras']);				
        $routes->get('compras/nuevo',    				'Compras::nuevo',     			['as' => 'comprasnuevo']);	
		$routes->get('compras/eliminados',			    'Compras::eliminados',     		['as' => 'compraselim']);	
		$routes->get('datatables',       				'Datatables::index',  			['as' => 'datatables']);	
		$routes->get('configuracion',    				'Configuracion::index',  		['as' => 'configuracion']);			
		$routes->get('monedas',          				'Monedas::index', 				['as' => 'monedas']);
		$routes->get('monedas/nuevo',          			'Monedas::nuevo', 				['as' => 'monedasnuevo']);
		$routes->get('monedas/editar/(:any)',    		'Monedas::editar/$1',     		['as' => 'monedaseditar']);				

        $routes->get('usuarios/nuevo',   				'Usuarios::nuevo',   			['as' => 'usuariosnuevo']);
		$routes->get('usuarios/editar/(:any)',			'Usuarios::editar/$1',			['as' => 'usuariossedit']);		
		$routes->get('usuarios/eliminados',       		'Usuarios::eliminados',   		['as' => 'usuarioselim']);		
		$routes->get('usuarios',         				'Usuarios::index',   			['as' => 'usuariosindex']);
		$routes->get('usuarios/logout',  				'Usuarios::logout',   			['as' => 'usuarioslogout']);
/*      --------- */		
		$routes->get('menus',            				'Menus::index',  				['as' => 'menus']);					
        $routes->get('menus/nuevo',   					'Menus::nuevo',   				['as' => 'menusnuevo']);		
		$routes->get('menus/editar/(:any)',				'Menus::editar/$1',				['as' => 'menusedit']);			
		$routes->get('menus/eliminados',       			'Menus::eliminados',   			['as' => 'menuselim']);				
/*      --------- */			
		$routes->get('roles',            				'Roles::index',  				['as' => 'roles']);	
		$routes->get('roles/nuevo',            			'Roles::nuevo',  				['as' => 'rolesnuevo']);
		$routes->get('roles/editar/(:any)',				'Roles::editar/$1',				['as' => 'rolesedit']);					
		$routes->get('roles/eliminados',       			'Roles::eliminados',   			['as' => 'rolesselim']);						
		
		$routes->get('permisos',         				'Permisos::index',  			['as' => 'permisos']);			
		$routes->get('permisos/nuevo',            		'Permisos::nuevo',  			['as' => 'permisosnuevo']);
		$routes->get('permisos/editar/(:any)',			'Permisos::editar/$1',			['as' => 'permisosedit']);					
		$routes->get('permisos/eliminados',       		'Permisos::eliminados',  		['as' => 'permisosselim']);						
/*      --------- */					
        $routes->get('envioemail',       				'EnvioEMail::index',   			['as' => 'envioemail']);	
/*      --------- */				
		$routes->get('encode/(:num)', 	 				'Encripcion::encodeData/$1',	['as' => 'encriptoid']);
		$routes->get('decode/(:any)', 	 				'Encripcion::decodeData/$1',	['as' => 'desencriptoid']);	

		$routes->post('datatables/totalHombres',		'Datatables::totalHombres',     ['as' => 'totalhombres']);
		$routes->post('datatables/totalMujeres',		'Datatables::totalMujeres',     ['as' => 'totalmujeres']);		
		$routes->post('datatables/totalActivos',		'Datatables::totalActivos',     ['as' => 'totalactivos']);				
		$routes->post('datatables/totalInactivos',		'Datatables::totalInactivos',   ['as' => 'totalinactivos']);						
		$routes->post('datatables/table_data',			'Datatables::table_data',		['as' => 'tabledata']);								
		// En app/Config/Routes.php
		$routes->post('productos/graficastockMinimoProductos', 'Productos::graficastockMinimoProductos');
		$routes->post('compras/graficacompras',     'Compras::graficacompras',     ['as' => 'graficacompras']);
});
