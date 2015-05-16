<?php

use Bleicker\Cms\Controller\NodeController;
use Bleicker\Cms\Controller\SetupController;
use Bleicker\Cms\Modules\ModuleInterface;

NodeController::register('Node Manager', 'A node controller', ModuleInterface::MANAGEMENT_GROUP, '/nodemanager')
	->addAllowedRoleName('Administrator')->addAllowedRoleName('Editor');

SetupController::register('Setup', 'Setup Controller', ModuleInterface::MANAGEMENT_GROUP, '/setup')
	->addAllowedRoleName('Administrator');
