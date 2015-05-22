<?php

use Bleicker\Cms\Controller\Frontend\NodeController;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Routing\RouterInterface;

/** @var RouterInterface $router */
$router = ObjectManager::get(RouterInterface::class);
$router
	->addRoute(NodeController::class, 'indexAction', '/', 'get')
	->addRoute(NodeController::class, 'showAction', '/{node}', 'get');

/**
 * Prefix every registered route with /{systemLocale}
 */
foreach ($router->getRoutes() as $route) {
	$router->addRoute($route->getClassName(), $route->getMethodName(), '/{systemLocale}' . $route->getPattern(), $route->getMethod());
}