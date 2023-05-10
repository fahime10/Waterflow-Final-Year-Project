<?php
/**
 * task_overview.php
 *
 * Depending upon the user's request, different pathways have been defined in this script.
 * The first pathway opens a web page to display all the relevant tasks for a selected project.
 * The other pathways deal with add, edit and delete of a task from the database.
 *
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/task_overview',
    function(Request $request, Response $response) use ($app) {
        $task_overview_controller = $app->getContainer()->get('taskOverviewController');
        $task_overview_controller->createHtmlOutput($app, $request, $response);
    }
);

$app->post(
    '/add_new_task',
    function(Request $request, Response $response) use ($app) {
        $add_task_controller = $app->getContainer()->get('taskOverviewController');
        $add_task_controller->createHtmlOutputAdd($app, $request, $response);
    }
);

$app->post(
    '/edit_task',
    function(Request $request, Response $response) use ($app) {
        $edit_task_controller = $app->getContainer()->get('taskOverviewController');
        $edit_task_controller->createHtmlOutputEdit($app, $request, $response);
    }
);

$app->post(
    '/delete_task',
    function(Request $request, Response $response) use ($app) {
        $delete_task_controller = $app->getContainer()->get('taskOverviewController');
        $delete_task_controller->createHtmlOutputDelete($app, $request, $response);
    }
);
