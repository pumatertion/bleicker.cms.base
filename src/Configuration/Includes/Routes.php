<?php

use Bleicker\Cms\Controller\AuthenticationController;
use Bleicker\Cms\Controller\NodeController;
use Bleicker\Cms\Controller\SetupController;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Routing\ControllerRouteData;
use Bleicker\Routing\RouteInterface;
use Bleicker\Routing\RouterInterface;

/** @var RouterInterface $router */
$router = ObjectManager::get(RouterInterface::class);
$router
	->addRoute('/', 'get', new ControllerRouteData(NodeController::class, 'indexAction'))
	->addRoute('/setup', 'get', new ControllerRouteData(SetupController::class, 'setupAction'))
	->addRoute('/setup/token', 'get', new ControllerRouteData(SetupController::class, 'newTokenAction'))
	->addRoute('/setup/token', 'post', new ControllerRouteData(SetupController::class, 'createTokenAction'))
	->addRoute('/setup/database', 'get', new ControllerRouteData(SetupController::class, 'setupDatabaseAction'))
	->addRoute('/setup/database', 'post', new ControllerRouteData(SetupController::class, 'createDatabaseAction'))
	->addRoute('/setup/schema', 'post', new ControllerRouteData(SetupController::class, 'createSchemaAction'))
	->addRoute('/setup/admin', 'get', new ControllerRouteData(SetupController::class, 'setupAdministratorAction'))
	->addRoute('/setup/admin', 'post', new ControllerRouteData(SetupController::class, 'createAdministratorAction'))
	->addRoute('/setup/authentication', 'get', new ControllerRouteData(SetupController::class, 'authenticationAction'))
	->addRoute('/setup/authentication', 'post', new ControllerRouteData(SetupController::class, 'setupAction'))
	->addRoute('/logout', 'get', new ControllerRouteData(AuthenticationController::class, 'logoutAction'))
	->addRoute('/authenticate', 'get', new ControllerRouteData(AuthenticationController::class, 'indexAction'))
	->addRoute('/authenticate', 'post', new ControllerRouteData(AuthenticationController::class, 'authenticateAction'))
	->addRoute('/nodemanager', 'get', new ControllerRouteData(NodeController::class, 'indexAction'))
	->addRoute('/nodemanager/add', 'post', new ControllerRouteData(NodeController::class, 'addAction'))
	->addRoute('/nodemanager/add/{reference}', 'post', new ControllerRouteData(NodeController::class, 'addWithReferenceAction'))
	->addRoute('/nodemanager/save', 'post', new ControllerRouteData(NodeController::class, 'createAction'))
	->addRoute('/nodemanager/update/{node}', 'post', new ControllerRouteData(NodeController::class, 'updateAction'))
	->addRoute('/nodemanager/update/{node}', 'patch', new ControllerRouteData(NodeController::class, 'updateAction'))
	->addRoute('/nodemanager/remove/{node}', 'delete', new ControllerRouteData(NodeController::class, 'removeAction'))
	->addRoute('/nodemanager/remove/{node}', 'get', new ControllerRouteData(NodeController::class, 'removeAction'))
	->addRoute('/nodemanager/{node}', 'get', new ControllerRouteData(NodeController::class, 'showAction'));

/**
 * Prefix every registered route with /{systemLocale}
 */
$router->dispatchClosure(function (RouterInterface $router) {
	/** @var RouteInterface $route */
	foreach ($router->getRoutes() as $route) {
		$router->addRoute('/{systemLocale}' . $route->getPattern(), $route->getMethod(), $route->getData());
	}
});
