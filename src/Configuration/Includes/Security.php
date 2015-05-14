<?php

use Bleicker\Authentication\AuthenticationManagerInterface;
use Bleicker\Cms\Controller\NodeController;
use Bleicker\Cms\Controller\SetupController;
use Bleicker\Cms\Security\Exception\LoginBoxException;
use Bleicker\Cms\Security\Exception\SetupLoginBoxException;
use Bleicker\Cms\Security\SetupToken;
use Bleicker\Cms\Security\UsernamePasswordToken;
use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Security\Vote;

UsernamePasswordToken::register();
SetupToken::register();

/**
 * Secure Node Controller
 */
Vote::register('SecuredController', function () {
	if (!ObjectManager::get(AuthenticationManagerInterface::class)->hasRole('Administrator')) {
		throw new LoginBoxException('Administrator privilege required.', 1431290565);
	}
}, NodeController::class . '::.*');

/**
 * Secure Setup
 */
Vote::register('SetupController', function () {
	if (!ObjectManager::get(AuthenticationManagerInterface::class)->hasRole('Setup.Administrator')) {
		throw new SetupLoginBoxException('Administrator privilege required.', 1431290566);
	}
}, SetupController::class . '::setupAction');
