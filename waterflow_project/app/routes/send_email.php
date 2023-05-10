<?php
/**
 * send_email.php
 *
 * This script opens a web page to display the interface of the email to be sent.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/send_email', function(Request $request, Response $response) use ($app)
{
    $send_email_controller = $app->getContainer()->get('sendEmailController');
    $send_email_controller->createHtmlOutput($app, $request, $response);
});