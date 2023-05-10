<?php
/**
 * login.php
 *
 * This script opens a web page for the login interface.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
{
    $login_page_controller = $app->getContainer()->get('loginController');
    $login_page_controller->createHtmlOutput($app, $request, $response);
});