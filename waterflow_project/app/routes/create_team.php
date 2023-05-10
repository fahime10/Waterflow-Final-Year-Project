<?php
/**
 * create_team.php
 *
 * This script opens the web page for creating a team.
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/create_team', function(Request $request, Response $response) use ($app)
{
    $create_team_controller = $app->getContainer()->get('createTeamController');
    $create_team_controller->createHtmlOutput($app, $request, $response);
});