<?php

/**
 * This is you FrontController, the only point of access to your webapp
 */
 
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

/**
 * Use Yaml components for load a config routing, $routes is in yaml app/config/routing.yml :
 *
 * Url will be /index.php?p=route_name
 *
 *
 */
$routes = Yaml::parse(file_get_contents(__DIR__.'/../app/config/routing.yml'));
if(isset($_GET['p'])){
    $page = $_GET['p'];
} else {
    $page = 'home';
}

//check if controller config exits in routing.yml
if (!empty($routes[$page]['controller'])) {
    $current_route = explode(':', $routes[$page]['controller']);
} else {
    throw new Exception('add routing config for '.$page.' in routing.yml');
}





//ControllerClassName, end name is ...Controller
$controller_class = $current_route[0];

//ActionName, end name is ...Action
$action_name = $current_route[1];

$controller = new $controller_class();

//$Request can by an object
$request['request'] = &$_POST;
$request['query'] = &$_GET;
$request['session'] = &$_SESSION;
//...

//$response can be an object
$response = $controller->$action_name($request);

/** do a redirection here if $response['redirect_to'] exists **/
if (!empty($response['redirect_to'])) {

    header('Location: ' . $response['redirect_to']);

} elseif (!empty($response['view'])) {

    /**
     * Use Twig !
     */
    require __DIR__ . '/../src/' . $response['view'];
} else {

    throw new Exception('response object is not complet');
}

