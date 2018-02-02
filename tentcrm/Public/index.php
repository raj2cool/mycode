<?php
/*
*PHP 7  front controller
*
*/
//echo 'REQUESTED url="'.$_SERVER['QUERY_STRING'].'"';
//require '../application/Controllers/Posts.php';		
//require '../core/Router.php';
/**
*Twig
*/


require_once dirname(__DIR__).'/vendor/Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
/**
* Autoloader
*/
spl_autoload_register(function ($class)
{
	$root = dirname(__DIR__); //get the parent directory
	$file = $root.'/'.str_replace('\\', '/', $class).'.php';
	if(is_readable($file)){
		require $root.'/'.str_replace('\\', '/', $class).'.php';
	}
});


$router = new Core\Router();
//echo get_class($router);
// Add the routes
$router->add('',['controller'=>'home','action'=>'index']);
$router->add('posts',['controller'=>'Posts','action'=>'index']);
//$router->add('posts/new',['controller'=>'Posts','sction'=>'new']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}',['namespace'=>'Admin']);

/*//Display routing table
echo '<pre>';
//var_dump($router->getRoutes());
echo htmlspecialchars(print_r($router->getRoutes(),true));
echo '</pre>';

//Match the requested route
$url=$_SERVER['QUERY_STRING'];
if($router->match($url)){
	echo '<pre>';
	echo var_dump($router->getParams());
	echo '</pre>';
}
else{
	echo "No route found for url '$url'";
}*/
$router->dispatch($_SERVER['QUERY_STRING']);