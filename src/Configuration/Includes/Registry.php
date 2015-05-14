<?php

use Bleicker\Registry\Registry;

/** Setup Root Path */
Registry::set('paths.root', realpath(__DIR__ . '/../../../'));

/** Doctrine Database Settings */
Registry::set('doctrine.db.default.url', 'sqlite://' . Registry::get('paths.root') . '.resources/persistence/db.sqlite');

/** Doctrine Schemas */
Registry::set('paths.doctrine.schema.nodes', Registry::get('paths.root') . '/vendor/bleicker/nodes/src/Schema/Persistence');
Registry::set('paths.doctrine.schema.nodestypes', Registry::get('paths.root') . '/vendor/bleicker/nodetypes/src/Schema/Persistence');
Registry::set('paths.doctrine.schema.account', Registry::get('paths.root') . '/vendor/bleicker/account/src/Schema/Persistence');

/** Fluid Paths */
Registry::set('paths.typo3.fluid.templateRootPaths.cms', Registry::get('paths.root') . '/src/Private/Templates/');
Registry::set('paths.typo3.fluid.layoutRootPaths.cms', Registry::get('paths.root') . '/src/Private/Layouts/');
Registry::set('paths.typo3.fluid.partialRootPaths.cms', Registry::get('paths.root') . '/src/Private/Partials/');

/** Cache Paths */
Registry::set('paths.cache.default', Registry::get('paths.root') . '/.resources/cache');

/** Uploads Paths */
Registry::set('paths.uploads.default', Registry::get('paths.root') . '/.resources/uploads');

/** Tokens Paths */
Registry::set('paths.tokens.default', Registry::get('paths.root') . '/.resources/tokens');

/** Load Local Settings if exists */
if (file_exists(__DIR__ . '/Registry.local.php')) {
	include __DIR__ . '/Registry.local.php';
}
