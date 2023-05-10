<?php
/**
 * save_progress.php
 *
 * This script opens a web page to display the result of the changes made in the task overview page.
 *
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/save_progress',
    function(Request $request, Response $response) use ($app) {
        $save_progress_controller = $app->getContainer()->get('saveController');
        $save_progress_controller->createHtmlOutput($app, $request, $response);
    }
);