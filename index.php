<?php 
// Definiramo globalno vidljive constante:
// __SITE_PATH = putanja na disku servera do index.php
// __SITE_URL  = URL do index.php
define( '__SITE_PATH', realpath( dirname( __FILE__ ) ) );
define( '__SITE_URL', dirname( $_SERVER['PHP_SELF'] ) );

// Započnemo/nastavimo session
session_start();

// Inicijaliziraj aplikaciju (učitava bazne klase, autoload klasa iz modela).
require_once 'app/init.php';

// Stvori zajednički registry podataka u aplikaciji.
$registry = new Registry();

// Stvori novi router, spremi ga u registry.
$registry->router = new Router($registry);

// Javi routeru putanju gdje su spremljeni svi controlleri.
$registry->router->setPath( __SITE_PATH . '/controller' );

// Stvori novi template za prikaz view-a.
$registry->template = new Template($registry);

// Učitaj controller pomoću routera.
$registry->router->loader();


/*
// Provjeri je li postavljena varijabla rt; kopiraj ju u $route
if( isset( $_GET['rt'] ) ){
	$route = $_GET['rt'];
}else
	$route = 'subject';


$parts = explode( '/', $route );
$controllerName = $parts[0] . 'Controller';
if( isset( $parts[1] ) )
	$action = $parts[1];
else
	$action = 'index';
// Controller $controllerName se nalazi poddirektoriju controller
$controllerFileName = 'controller/' . $controllerName . '.php';
// Includeaj tu datoteku
if( !file_exists( $controllerFileName ) )
{
	$controllerName = '_404Controller';
	$controllerFileName = 'controller/' . $controllerName . '.php';
}
require_once $controllerFileName;
// Stvori pripadni kontroler
$con = new $controllerName; 
// Ako u njemu nema tražene akcije, stavi da se traži akcija index
if( !method_exists( $con, $action ) )
	$action = 'index';
// Pozovi odgovarajuću akciju
$con->$action();
*/



?>
