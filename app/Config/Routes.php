<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php'))
{
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('info', 'Home::getInfo');
$routes->get('listroles', 'RolesController::listRoles');
$routes->get('getcities', 'TerminalsController::getAll');

$routes->post('authenticate', 'UserLogin::authenticate');
$routes->post('userregister', 'UserLogin::register');
$routes->post('seferlerial','BusRoutesController::getRoutes');
$routes->post('pnrcontrol','TicketsController::checkPnr');
$routes->post('getBusStatus', 'TicketsController::getBusStatus');

$routes->get('adminuserlist', 'AdminUserController::adminuserlist');
$routes->get('busCompaniesedit/(:num)', 'BusCompaniesController::edit/$1');
$routes->get('busCompaniesshow/(:num)', 'BusCompaniesController::show/$1');
$routes->get('busCompaniescreate', 'BusCompaniesController::create');

$routes->post('busCompaniesstore', 'BusCompaniesController::store');
$routes->post('busCompaniesupdate/(:num)', 'BusCompaniesController::update/$1');
$routes->post('busCompaniesdelete/(:num)', 'BusCompaniesController::delete/$1');

$routes->post('register', 'UserRegisterController::registerUsers');

$routes->get('adminprofile', 'AdminProfileController::index');
$routes->post('adminupdate', 'AdminProfileController::update');

$routes->get('adminreservations', 'AdminReservationController::index');
$routes->get('adminreservationsshow/(:num)', 'AdminReservationController::show/$1');
$routes->get('adminreservationsedit/(:num)', 'AdminReservationController::edit/$1');
$routes->post('adminreservationsupdate/(:num)', 'AdminReservationController::update/$1');
$routes->post('adminreservationsdelete/(:num)', 'AdminReservationController::delete/$1');
$routes->get('adminreservationsuser-list', 'AdminReservationController::userList');
$routes->get('adminreservationsuser-reservations/(:num)', 'AdminReservationController::userReservations/$1');


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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}