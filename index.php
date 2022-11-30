<?php

use Slim\App;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Instantiate the app
 */
$settings = require_once __DIR__ . '/app/src/settings.php';

/**
 * @var $app App
 */
$app = new App($settings);

/**
 * Set up dependencies
 */
require_once __DIR__ . '/app/src/dependencies.php';

/**
 * Register middleware
 */
require_once __DIR__ . '/app/src/middleware.php';

/**
 * Register routes
 */
require_once __DIR__ . '/app/src/routes.php';

/**
 * Run app
 */
$app->run();