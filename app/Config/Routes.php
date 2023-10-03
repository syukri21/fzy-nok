<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Controllers\LogoutController;
use App\Controllers\ProductionResultController;

$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::authenticate');
$routes->get('/logout', 'LogoutController::index');
$routes->get('/changepassword', 'LoginController::index');


// User Management
$routes->get('/usermanagement', 'UserManagementController::index');
$routes->get('/usermanagement/manageuser', 'UserManagementController::index');
$routes->post('/usermanagement/manageuser', 'UserManagementController::create');
$routes->post('/usermanagement/manageuser/update', 'UserManagementController::update');
$routes->get('/usermanagement/manageuser/delete', 'UserManagementController::delete');

$routes->get('/usermanagement/manageuser/add', 'UserManagementController::add');
$routes->get('/usermanagement/manageuser/edit', 'UserManagementController::edit');

// MAster DATA
$routes->get('/masterdata', 'MasterDataController::index');
$routes->get('/masterdata/managemasterdata', 'MasterDataController::index');
$routes->get('/masterdata/managemasterdata/add', 'MasterDataController::add');
$routes->post('/masterdata/managemasterdata/update', 'MasterDataController::update');
$routes->get('/masterdata/managemasterdata/edit', 'MasterDataController::edit');
// action
$routes->post('/masterdata/managemasterdata', 'MasterDataController::create');
$routes->get('/masterdata/managemasterdata/delete', 'MasterDataController::delete');

// BOM
$routes->get('/masterdata/managebom', 'BillOfMaterialController::index');
$routes->get('/masterdata/managebom', 'BillOfMaterialController::index');
$routes->get('/masterdata/managebom/add', 'BillOfMaterialController::add');
$routes->post('/masterdata/managebom/update', 'BillOfMaterialController::update');
$routes->get('/masterdata/managebom/edit', 'BillOfMaterialController::edit');
// action
$routes->post('/masterdata/managebom', 'BillOfMaterialController::create');
$routes->get('/masterdata/managebom/delete', 'BillOfMaterialController::delete');


// API
$routes->delete('/masterdata/api/material', 'BillOfMaterialController::deleteMaterial');
$routes->post('/masterdata/api/material', 'BillOfMaterialController::insertMaterial');


// Production Plan
$routes->get('/production/plan', 'ProductionPlanController::index');
$routes->get('/production/plan/add', 'ProductionPlanController::add');
$routes->post('/production/plan/update', 'ProductionPlanController::update');
$routes->get('/production/plan/edit', 'ProductionPlanController::edit');

// Production Plan API
$routes->get('/api/production/plan', 'ProductionPlanController::get');


// Production Running
$routes->get('/production/running', 'ProductionRunningController::index');

// Production Results
$routes->get('/production/result', 'ProductionResultController::index');
$routes->post('/production/result/add', 'ProductionResultController::add');
$routes->post('/production/result/update', 'ProductionResultController::update');
$routes->get('/production/result/delete', 'ProductionResultController::delete');

service('auth')->routes($routes);


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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
