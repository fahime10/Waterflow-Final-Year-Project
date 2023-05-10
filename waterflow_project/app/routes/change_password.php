<?php
/**
 * change_password.php
 *
 * This script opens the web page for changing the password.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/change_password', function(Request $request, Response $response) use ($app)
{
    $change_password_controller = $app->getContainer()->get('changePasswordController');
    $change_password_controller->createHtmlOutput($app, $request, $response);
});

$app->post('/change_password', function(Request $request, Response $response) use ($app)
{
    $change_password_controller = $app->getContainer()->get('changePasswordController');
    $change_password_controller->createHtmlOutput($app, $request, $response);
});