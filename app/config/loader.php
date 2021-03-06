<?php

use Phalcon\Loader;

$loader = new Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces([
    'Vokuro\Models'      => $config->application->modelsDir,
    'Vokuro\Controllers' => $config->application->controllersDir,
    'Vokuro\Forms'       => $config->application->formsDir,
    'Vokuro\Components'  => $config->application->componentsDir,
    'Vokuro'             => $config->application->libraryDir,
    'Common\Helpers'     => $config->application->helpersDir,
    'Common\Behaviors'   => $config->application->behaviorsDir,
    'Common\Traits'      => $config->application->trainsDir,
    'Common\Bases'       => $config->application->basesDir,
]);


$loader->register();


// Use composer autoloader to load vendor classes
require_once __DIR__ . '/../../vendor/autoload.php';
