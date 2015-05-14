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
Vote::register('SetupController::setupAction', function () {
	if (!ObjectManager::get(AuthenticationManagerInterface::class)->hasRole('Setup.Administrator')) {
		throw new SetupLoginBoxException('Administrator privilege required.', 1431290566);
	}
}, SetupController::class . '::setupAction');

/**
 * Secure Setup
 */
Vote::register('SetupController::setupDatabaseAction', function () {
	if (!ObjectManager::get(AuthenticationManagerInterface::class)->hasRole('Setup.Administrator')) {
		throw new SetupLoginBoxException('Administrator privilege required.', 1431290567);
	}
}, SetupController::class . '::setupDatabaseAction');

/**
 * Secure Setup
 */
Vote::register('SetupController::createDatabaseAction', function () {
	if (!ObjectManager::get(AuthenticationManagerInterface::class)->hasRole('Setup.Administrator')) {
		throw new SetupLoginBoxException('Administrator privilege required.', 1431290568);
	}
}, SetupController::class . '::createDatabaseAction');

/**
 * Secure Setup
 */
Vote::register('SetupController::createSchemaAction', function () {
	if (!ObjectManager::get(AuthenticationManagerInterface::class)->hasRole('Setup.Administrator')) {
		throw new SetupLoginBoxException('Administrator privilege required.', 1431290569);
	}
}, SetupController::class . '::createSchemaAction');

/**
 * Secure Setup
 */
Vote::register('SetupController::setupAdministratorAction', function () {
	if (!ObjectManager::get(AuthenticationManagerInterface::class)->hasRole('Setup.Administrator')) {
		throw new SetupLoginBoxException('Administrator privilege required.', 1431290570);
	}
}, SetupController::class . '::setupAdministratorAction');

/**
 * Secure Setup
 */
Vote::register('SetupController::createAdministratorAction', function () {
	if (!ObjectManager::get(AuthenticationManagerInterface::class)->hasRole('Setup.Administrator')) {
		throw new SetupLoginBoxException('Administrator privilege required.', 1431290571);
	}
}, SetupController::class . '::createAdministratorAction');
