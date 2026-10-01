<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

// Admin Login Processing Routes
$routes->get('admin', 'Admin\Login::index');
$routes->post('admin/login', 'Admin\Login::authenticate'); // Points to authenticate()

// Dashboard & Logout System Routes
$routes->get('dashboard', 'Admin\Login::dashboard');
$routes->get('logout', 'Admin\Login::logout');

$routes->get('departments/cet', 'DepartmentController::cet');
$routes->get('departments/cas', 'DepartmentController::cas');
$routes->get('departments/caf', 'DepartmentController::caf');
$routes->get('departments/cbm', 'DepartmentController::cbm');
$routes->get('departments/cvm', 'DepartmentController::cvm');
$routes->get('departments/ced', 'DepartmentController::ced');
$routes->get('/research', 'Research::index');
$routes->get('about', 'Home::about');
$routes->get('admissions', 'Admissions::index');
$routes->get('departments/(:segment)', 'Admissions::department/$1');
$routes->get('careers', 'Careers::index');
$routes->get('admin/dashboard', 'Admin\Admin::index');
$routes->get('history', 'History::index');
$routes->get('offices', 'Offices::index');


// Route group for controllers inside the app/Controllers/Admin/ subfolder
$routes->group('admin', function($routes) {
    $routes->get('research', 'Admin\Research::index');
    $routes->get('research/edit/(:num)', 'Admin\Research::edit/$1');
    $routes->post('research/update/(:num)', 'Admin\Research::update/$1');


    $routes->get('offices', 'Admin\Offices::index');
    $routes->get('offices/create', 'Admin\Offices::create');
    $routes->post('offices/store', 'Admin\Offices::store');
    $routes->get('offices/edit/(:num)', 'Admin\Offices::edit/$1');
    $routes->post('offices/update/(:num)', 'Admin\Offices::update/$1');
    $routes->post('offices/delete/(:num)', 'Admin\Offices::delete/$1');
});