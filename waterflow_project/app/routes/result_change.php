<?php
/**
 * result_change.php
 *
 * This script opens a web page to display the result of the changed password.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/result_change', function(Request $request, Response $response) use ($app)
{
    $result_change_controller = $app->getContainer()->get('resultChangeController');
    $result_change_controller->createHtmlOutput($app, $request, $response);
});