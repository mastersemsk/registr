<?php
const SRC_DIR = __DIR__ . '/../back/';

require '../vendor/autoload.php';
spl_autoload_register(function ($class) {
    include SRC_DIR .  str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
});

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Controllers\AppController;

$routes = require_once SRC_DIR.'routes.php';
$dispatcher = FastRoute\simpleDispatcher($routes);

// Получить метод и URI откуда-то
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Разделить строку запроса (?foo=bar) и декодировать URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
		http_response_code(404);
        echo '404'; //$container['twig']->render('404.twig');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
		echo '405';
        break;
    case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars    = $routeInfo[2];
    if (is_object($handler) || (is_string($handler) && strpos($handler, '\\') === false)) {
        if (count($vars) > 0) {
            call_user_func_array($handler,$vars);
        } else {
            call_user_func_array($handler,array());
        }
    } elseif (is_array($handler)) {       
		$handler = $routeInfo[1];
        $vars = $routeInfo[2];
		call_user_func_array([new $handler[0](), $handler[1]], $vars);
    }
    break;
	default: echo 'Error url'; break;
}