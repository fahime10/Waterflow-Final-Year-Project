<?php
/**
 * view_reports.php
 *
 * This script opens a web page to display an interface with all the reports saved in the application, ready to
 * be viewed.
 *
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/view_reports',
    function(Request $request, Response $response) use ($app) {
        $view_reports_controller = $app->getContainer()->get('viewReportsController');
        $view_reports_controller->createHtmlOutput($app, $request, $response);
    }
);