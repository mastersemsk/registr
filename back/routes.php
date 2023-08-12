<?php
use FastRoute\RouteCollector;
// определяем контроллеры вызываемые по определённым путям
use Controllers\HomeController;
use Controllers\Auth\AuthController;
use Controllers\Auth\RegisterController;
use Controllers\Auth\PanelController;
use Controllers\Auth\PasswordResetController;

return function (RouteCollector $r) {
$r->addRoute('GET', '/', [HomeController::class, 'index']);
$r->addRoute('GET', '/login', [AuthController::class, 'in']);
$r->addRoute('POST', '/login', [AuthController::class, 'prov']);
$r->addRoute('GET', '/logout', [AuthController::class, 'logout']);
$r->addRoute('GET', '/register', [RegisterController::class, 'reg']);
$r->addRoute('POST', '/register', [RegisterController::class, 'prov']);
$r->addRoute('GET', '/register/{id:\d+}/{token}', [RegisterController::class, 'prov_email']);
$r->addRoute('GET', '/forgot-password', [PasswordResetController::class, 'form_pass']);
$r->addRoute('GET', '/panel/requisites', [PanelController::class, 'requisites']);
$r->addRoute('GET', '/panel/report', [PanelController::class, 'report']);
// {id} must be a number (\d+)
//$r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
// The /{title} suffix is optional
//$r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
};