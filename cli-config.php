<?php

use Bleicker\ObjectManager\ObjectManager;
use Bleicker\Persistence\EntityManagerInterface;

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . '/src/Configuration/Shared/Registry.php';
include __DIR__ . '/src/Configuration/Shared/Cache.php';
include __DIR__ . '/src/Configuration/Shared/Persistence.php';

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(ObjectManager::get(EntityManagerInterface::class));
