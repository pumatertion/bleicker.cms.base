<?php

use Bleicker\Cms\Controller\NodeController;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Routing\ControllerRouteData;
use Bleicker\Routing\RouteInterface;
use Bleicker\Routing\RouterInterface;

/** @var RouterInterface $router */
$router = ObjectManager::get(RouterInterface::class);
$router->addRoute('/', 'get', new ControllerRouteData(NodeController::class, 'indexAction'));

/**
 * Prefix every registered route with /{systemLocale}
 */
$router->dispatchClosure(function (RouterInterface $router) {
	/** @var RouteInterface $route */
	foreach ($router->getRoutes() as $route) {
		$router->addRoute('/{systemLocale}' . $route->getPattern(), $route->getMethod(), $route->getData());
	}
});
