<?php
/**
 * bootstrap.php
 *
 * This script defines the pathways to specific files, which lead to opening the application.
 *
 * The script also starts a session.
 *
 */
session_start();

use Slim\App;
use Slim\Container;

require 'vendor/autoload.php';

$app_path = __DIR__ . '/app/';

$settings = require $app_path . 'settings.php';

$container = new Container($settings);

require $app_path . 'dependencies.php';

$app = new App($container);

require $app_path . 'routes.php';

try {
    $app->run();
} catch(Exception $e) {
    die(json_encode(array("status" => "failed", "message" => "This action is not allowed")));
}