<?php
/**
 * display_report.php
 *
 * This script opens a web page for displaying a selected report.
 *
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/display_report',
    function(Request $request, Response $response) use ($app) {
        $display_report_controller = $app->getContainer()->get('displayReportController');
        $display_report_controller->createHtmlOutput($app, $request, $response);
    }
);