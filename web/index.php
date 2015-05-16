<?php

include __DIR__ . '/../vendor/autoload.php';

use Bleicker\Exception\ThrowableException;
use Bleicker\Framework\ApplicationFactory;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

try {
	ApplicationFactory::http(
		function () {
			include __DIR__ . '/../src/Configuration/Before.php';
		},
		function () {
			include __DIR__ . '/../src/Configuration/After.php';
		}
	)->run();
} catch (Exception $exception) {
	if ($exception instanceof ThrowableException) {
		throw $exception;
	}
	/** @todo logging */
	throw $exception;
}
