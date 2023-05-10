<?php
/**
 * CreateTeamController.php
 *
 * This class uses createHtmlOutput to create an HTML output to create a form for the user to complete.
 * The form is about creating a team.
 *
 */
namespace Waterflow\Controller;

class CreateTeamController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and CreateTeamView class.
     *
     * The class CreateTeamModel uses an instance of the DatabaseWrapper, Validator and SqlQueries classes to validate
     * the user's data and then save them to the database.
     *
     * @param $app 'The SLIM application defined in settings.php'
     * @param $request 'The request from the user sent as parameter'
     * @param $response 'The response to be handled when view is processed'
     * @return void 'Return the web page'
     *
     */
    public function createHtmlOutput($app, $request, $response)
    {
        $input_parameters = $request->getParsedBody();

        $view = $app->getContainer()->get('view');
        $db_wrapper = $app->getContainer()->get('databaseWrapper');
        $validator = $app->getContainer()->get('validator');

        $create_team_model = $app->getContainer()->get('createTeamModel');
        $create_team_view = $app->getContainer()->get('createTeamView');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        if (!empty($_SESSION)) {
            if(!empty($input_parameters)) {

                $cleaned_parameters = $create_team_model->cleanParameters($validator, $input_parameters);
                $team_name = $create_team_model->createTeam($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters);
                $create_team_view->createTeamViewResult($view, $response, $team_name, $cleaned_parameters);

            } else {
                $users = $create_team_model->retrieveAllUsers($db_connection_settings, $sql_queries, $db_wrapper);
                $create_team_view->createTeamView($view, $response, $users);
            }

        } else {
            $create_team_view->createViewError($view, $response);
        }
    }
}