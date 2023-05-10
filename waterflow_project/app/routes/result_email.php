<?php
/**
 * result_email.php
 *
 * This script opens a web page  to display the result of the intended email.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/result_email', function(Request $request, Response $response) use ($app)
{
    $result_email_controller = $app->getContainer()->get('resultEmailController');
    $result_email_controller->createHtmlOutput($app, $request, $response);
});