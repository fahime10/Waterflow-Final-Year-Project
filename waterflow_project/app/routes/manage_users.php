<?php
/**
 * manage_users.php
 *
 * Depending upon the user's request, different pathways have been defined in this script.
 * The first pathway simply opens a web page to display all the users and teams stored in the database.
 * The other pathways deal with add, edit and delete of a user from the database.
 *
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/manage_users',
    function(Request $request, Response $response) use ($app) {
        $manage_users_controller = $app->getContainer()->get('manageUsersController');
        $manage_users_controller->createHtmlOutput($app, $request, $response);
    }
);

$app->post(
    '/add_new_user',
    function(Request $request, Response $response) use ($app) {
        $add_user_controller = $app->getContainer()->get('manageUsersController');
        $add_user_controller->createHtmlOutputAdd($app, $request, $response);
    }
);

$app->post(
    '/edit_user',
    function(Request $request, Response $response) use ($app) {
        $edit_user_controller = $app->getContainer()->get('manageUsersController');
        $edit_user_controller->createHtmlOutputEdit($app, $request, $response);
    }
);


$app->post(
    '/delete_user',
    function(Request $request, Response $response) use ($app) {
        $delete_user_controller = $app->getContainer()->get('manageUsersController');
        $delete_user_controller->createHtmlOutputDelete($app, $request, $response);
    }
);

$app->post(
    '/delete_teammate',
    function(Request $request, Response $response) use ($app) {
        $delete_teammate_controller = $app->getContainer()->get('manageUsersController');
        $delete_teammate_controller->createHtmlOutputDeleteTeam($app, $request, $response);
    }
);