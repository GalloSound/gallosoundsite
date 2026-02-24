<?php
session_start();
require '../../gsfacilsite/vendor/autoload.php';
require '../../gsfacilsite/src/routes.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$router->run( $router->routes );