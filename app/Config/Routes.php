<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//				--- WEB ---
$routes->get('/', 							'Asesores::index');
$routes->get('/finSesion', 					'Asesores::destruirSession');
$routes->post('/inicio', 					'Asesores::login');
$routes->get('/inicio', 					'Asesores::login');
$routes->get('/clientes', 					'Asesores::clientes');
$routes->post('/insertC', 					'Asesores::insertCliente');
$routes->post('/updateC', 					'Asesores::actualizarCliente');
$routes->post('/deleteC', 					'Asesores::eliminarCliente');
$routes->get('/tareas', 					'Asesores::tareas');
$routes->post('/insertT', 					'Asesores::insertTarea');
$routes->get('/promo', 	    				'Asesores::promociones');
$routes->post('/dropzoneI',					'Asesores::insertDropzone');
$routes->get('/actividades', 				'Asesores::actividad');
$routes->get('/plancom', 					'Asesores::planComercial');
$routes->post('/lecturaE', 					'Asesores::lecturaExcel');
$routes->get('/reporte',        			'Asesores::ventasReporte');
$routes->get('/historial',  		      	'Asesores::historiales');
$routes->get('/catalogoW',        			'Asesores::catalogoProd');

$routes->post('/selclusu', 					'Asesores::selectClientesAse');
$routes->post('/insertPri', 				'Asesores::insertPrivilegio');
$routes->get('/privilegios',        		'Asesores::privilegios');
$routes->post('/insertR',  		      		'Asesores::insertarROL');
$routes->post('/insertRR',  		      	'Asesores::insertarROLRUTA');
$routes->post('/cargaRuta',  		      	'Asesores::cargaDatos');

//				--- API ---
$routes->post('/gestion/generico',          'ApiGestion::getDataMega');
$routes->post('/gestion/generico1',         'ApiGestion::getDataMega1');

$routes->post('/gestion',                	'ApiGestion::index');
$routes->post('/gestion/login',             'ApiGestion::login');
$routes->post('/gestion/auth',              'ApiGestion::autenticacion');
$routes->post('/gestion/delete',            'ApiGestion::borrarDatos');
//                  ---tbl_rutas---
$routes->post('/gestion/r',           		'ApiGestion::selectRutas');
$routes->post('/gestion/sr',           		'ApiGestion::selectRutasTotal');
$routes->post('/gestion/insRut',           	'ApiGestion::insertRolRuta');
//					---tbl_asesores----
$routes->post('/gestion/ase',           	'ApiGestion::asesores');
$routes->post('/gestion/ia',           		'ApiGestion::insertAsesores');
//					---tbl_catalogo----
$routes->get('/gestion/cat',         		'ApiGestion::catalogo');
$routes->post('/gestion/icatalogo',         'ApiGestion::insertCatalogo');
$routes->get('/gestion/catalogo',           'ApiGestion::selectCatalogo');
//					---tbl_clientes----
//$routes->get('/gestion/cli',            	'ApiGestion::clientesAsesor');
$routes->post('/gestion/asecli',            'ApiGestion::asesorCliente');
$routes->post('/gestion/ic',            	'ApiGestion::insertCliente');
$routes->post('/gestion/uc',            	'ApiGestion::updateCliente');
$routes->post('/gestion/dc',            	'ApiGestion::deleteCliente');
$routes->post('/gestion/cl',            	'ApiGestion::selectClientes');
$routes->post('/gestion/sc',            	'ApiGestion::sClientes');
$routes->post('/gestion/scu',            	'ApiGestion::sClientesU');
//					---tbl_facturas---
$routes->post('/gestion/clifac',            'ApiGestion::clientesFacturas');
//					---tbl_comercial----
$routes->post('/gestion/c',         		'ApiGestion::selectComercial');
$routes->post('/gestion/ipc',         		'ApiGestion::insertarPlanComercial');
//					---tbl_progsemanal----
$routes->post('/gestion/is',            	'ApiGestion::insertSemana');
$routes->post('/gestion/s',            		'ApiGestion::selectSemana');
$routes->post('/gestion/usuSema',      		'ApiGestion::selectSemanaUsuario');
//					---tbl_stock----
$routes->post('/gestion/ist',           	'ApiGestion::insertStock');
$routes->post('/gestion/st',           		'ApiGestion::selectStock');
//					---tbl_tareas----
$routes->post('/gestion/itareas',           'ApiGestion::insertTareas');
$routes->post('/gestion/it',        		'ApiGestion::insertSemanaTarea');
$routes->post('/gestion/t',        			'ApiGestion::selectTareas');
//					---tbl_usuarios----
$routes->post('/gestion/admin',           	'ApiGestion::administrativos');
$routes->post('/gestion/iu',           		'ApiGestion::inserUsuario');
$routes->post('/gestion/u',            		'ApiGestion::selectUsuario');
$routes->post('/gestion/su',            	'ApiGestion::sUsuario');
$routes->post('/gestion/sus',            	'ApiGestion::sUsuarios');
//					---tbl_visitado----
$routes->post('/gestion/iv',            	'ApiGestion::insertVisitado');
$routes->post('/gestion/v',            		'ApiGestion::selectVisitados');
//					---tbl_promociones----
$routes->post('/gestion/promo',             'ApiGestion::selectPromo');
//					---tbl_rol----
$routes->post('/gestion/srol',              'ApiGestion::selectRol');
$routes->post('/gestion/srl',             	'ApiGestion::selectRolTotal');
$routes->post('/gestion/ipriv',             'ApiGestion::insertPrivg');
$routes->post('/gestion/insRol',            'ApiGestion::insertRoles');
//					---tbl_visitas----
$routes->post('/gestion/sventas',           'ApiGestion::selectVentas');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
