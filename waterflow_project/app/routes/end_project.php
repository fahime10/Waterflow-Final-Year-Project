<?php
/**
 * end_project.php
 *
 * This script opens a web page to show the report of the finished project.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/end_project', function(Request $request, Response $response) use ($app)
{
    $end_project_controller = $app->getContainer()->get('endProjectController');
    $end_project_controller->createHtmlOutput($app, $request, $response);
});