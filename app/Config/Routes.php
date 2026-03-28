<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/student', 'StudentController::index');
$routes->get('/students', 'StudentController::index');
$routes->get('/student/list', 'StudentController::index');
$routes->get('/student/create', 'StudentController::create');
$routes->post('/save', 'StudentController::save');
$routes->get('/student/list', 'StudentController::index');

// Student AJAX routes
$routes->post('/student/ajaxSave', 'StudentController::ajaxSave');
$routes->post('/student/ajaxUpdate', 'StudentController::ajaxUpdate');
$routes->post('/student/ajaxDelete', 'StudentController::ajaxDelete');



//employee task 2 routes below

$routes->get('/employee/create', 'EmployeeController::create');
$routes->post('/employee/store', 'EmployeeController::store');
$routes->get('/employee', 'EmployeeController::index');
$routes->get('/employees', 'EmployeeController::index');
$routes->get('/employee/list', 'EmployeeController::index');
$routes->post('/employee/ajaxUpdate', 'EmployeeController::ajaxUpdate');
$routes->post('/employee/ajaxDelete', 'EmployeeController::ajaxDelete');




//course task 3 routes below

$routes->get('/course/create', 'CourseController::create');
$routes->post('/course/store', 'CourseController::store');
$routes->get('/course', 'CourseController::index');
$routes->get('/courses', 'CourseController::index');
$routes->get('/course/list', 'CourseController::index');
$routes->post('/course/ajaxUpdate', 'CourseController::ajaxUpdate');
$routes->post('/course/ajaxDelete', 'CourseController::ajaxDelete');


//product task 4 routes below

$routes->get('/product/create', 'ProductController::create');
$routes->post('/product/store', 'ProductController::store');
$routes->get('/product', 'ProductController::index');
$routes->get('/products', 'ProductController::index');
$routes->get('/product/list', 'ProductController::index');
$routes->post('/product/ajaxUpdate', 'ProductController::ajaxUpdate');
$routes->post('/product/ajaxDelete', 'ProductController::ajaxDelete');



//incident log task 5 routes below

$routes->get('/incident/add', 'IncidentController::add');
$routes->post('/incident/save', 'IncidentController::saveIncident');
$routes->get('/incident', 'IncidentController::viewIncidents');
$routes->get('/incidents', 'IncidentController::viewIncidents');
$routes->get('/incident/list', 'IncidentController::viewIncidents');
$routes->post('/incident/ajaxUpdate', 'IncidentController::ajaxUpdate');
$routes->post('/incident/ajaxDelete', 'IncidentController::ajaxDelete');