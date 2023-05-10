<?php
/**
 * project_overview.php
 *
 * Depending upon the user's request, different pathways have been defined in this script.
 * The first pathway opens a web page to display all the relevant projects.
 * The other pathways deal with add, edit and delete of a project from the database.
 *
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/project_overview',
    function(Request $request, Response $response) use ($app) {
        $project_overview_controller = $app->getContainer()->get('projectOverviewController');
        $project_overview_controller->createHtmlOutput($app, $request, $response);
    }
);

$app->post(
    '/start_project',
    function(Request $request, Response $response) use ($app) {
        $start_project_controller = $app->getContainer()->get('projectOverviewController');
        $start_project_controller->createHtmlOutputStart($app, $request, $response);
    }
);

$app->post(
    '/edit_project',
    function(Request $request, Response $response) use ($app) {
        $edit_project_controller = $app->getContainer()->get('projectOverviewController');
        $edit_project_controller->createHtmlOutputEdit($app, $request, $response);
    }
);

$app->post(
    '/delete_project',
    function(Request $request, Response $response) use ($app) {
        $delete_project_controller = $app->getContainer()->get('projectOverviewController');
        $delete_project_controller->createHtmlOutputDelete($app, $request, $response);
    }
);