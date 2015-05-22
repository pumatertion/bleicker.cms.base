<?php

use Bleicker\Cms\Controller\AuthenticationController;
use Bleicker\Cms\Controller\NodeController;
use Bleicker\Cms\Controller\SetupController;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Routing\RouterInterface;

/** @var RouterInterface $router */
$router = ObjectManager::get(RouterInterface::class);
$router

	/**
	 * SetupController Routes
	 */
	->addRoute(SetupController::class, 'setupAction', '/setup', 'get')
	->addRoute(SetupController::class, 'newTokenAction', '/setup/token', 'get')
	->addRoute(SetupController::class, 'createTokenAction', '/setup/token', 'post')
	->addRoute(SetupController::class, 'setupDatabaseAction', '/setup/database', 'get')
	->addRoute(SetupController::class, 'createDatabaseAction', '/setup/database', 'post')
	->addRoute(SetupController::class, 'createSchemaAction', '/setup/schema', 'post')
	->addRoute(SetupController::class, 'setupAdministratorAction', '/setup/admin', 'get')
	->addRoute(SetupController::class, 'createAdministratorAction', '/setup/admin', 'post')
	->addRoute(SetupController::class, 'authenticationAction', '/setup/authentication', 'get')
	->addRoute(SetupController::class, 'setupAction', '/setup/authentication', 'post')

	/**
	 * AuthenticationController Routes
	 */
	->addRoute(AuthenticationController::class, 'logoutAction', '/logout', 'get')
	->addRoute(AuthenticationController::class, 'indexAction', '/authenticate', 'get')
	->addRoute(AuthenticationController::class, 'authenticateAction', '/authenticate', 'post')

	/**
	 * NodeController Routes
	 */
	->addRoute(NodeController::class, 'indexAction', '/', 'get')
	->addRoute(NodeController::class, 'indexAction', '/nodemanager', 'get')
	->addRoute(NodeController::class, 'addAction', '/nodemanager/add', 'post')
	->addRoute(NodeController::class, 'addWithReferenceAction', '/nodemanager/add/{reference}', 'post')
	->addRoute(NodeController::class, 'updateAction', '/nodemanager/update/{node}', 'post')
	->addRoute(NodeController::class, 'updateAction', '/nodemanager/update/{node}', 'patch')
	->addRoute(NodeController::class, 'removeAction', '/nodemanager/remove/{node}', 'delete')
	->addRoute(NodeController::class, 'removeAction', '/nodemanager/remove/{node}', 'get')
	->addRoute(NodeController::class, 'showAction', '/nodemanager/{node}', 'get');

/**
 * Prefix every registered route with /{systemLocale}
 */
foreach ($router->getRoutes() as $route) {
	$router->addRoute($route->getClassName(), $route->getMethodName(), '/{systemLocale}' . $route->getPattern(), $route->getMethod());
}
