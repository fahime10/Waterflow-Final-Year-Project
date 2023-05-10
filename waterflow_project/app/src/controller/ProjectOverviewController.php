<?php
/**
 * ProjectOverviewController.php
 *
 * This class uses a series of functions to produce an HTML output according to user's request using instances of
 * ProjectOverviewModel and ProjectOverviewView class.
 * The first pathway function is about displaying relevant projects, depending on user's clearance level.
 * The first pathway also manages the user search from the database to see if the user exists and whether it has
 * access to certain functionalities.
 *
 * The other pathways functions display forms for add, edit and delete of a project.
 *
 */
namespace Waterflow\Controller;

class ProjectOverviewController
{
    /**
     * Method createHtmlOutput
     * This method create an HTML output using an instance of view and ProjectOverviewView class.
     * The model class, ProjectOverviewModel, uses instance of DatabaseWrapper, SqlQueries and Validator to validate
     * inputted data and to store/retrieve projects.
     *
     * The method executes different queries depending on the number of input parameters from a previous page.
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
        $validator = $app->getContainer()->get('validator');

        $db_wrapper = $app->getContainer()->get('databaseWrapper');

        $project_overview_model = $app->getContainer()->get('projectOverviewModel');
        $project_overview_view = $app->getContainer()->get('projectOverviewView');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        $project_array = [];
        $count_parameters = count($input_parameters);

        if (isset($_SESSION['first_name']) && empty($input_parameters['team_name']) && empty($input_parameters['project_name']) &&
            empty($input_parameters['project_id'])) {
            if ($_SESSION['clearance'] > 2) {
                $project_array = $project_overview_model->retrieveAllProjects($db_connection_settings, $sql_queries, $db_wrapper);
            } else {
                $project_array = $project_overview_model->retrieveRelevantProjects($db_connection_settings, $sql_queries, $db_wrapper, $_SESSION['username']);
            }

            $project_overview_view->createProjectOverviewView($view, $response, $_SESSION['first_name'], $project_array);

        } else if ($count_parameters > 0 && !empty($_SESSION)) {
            switch ($count_parameters) {
                case 1:
                    $project_overview_model->deleteProject($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters);
                    $project_array = $project_overview_model->retrieveAllProjects($db_connection_settings, $sql_queries, $db_wrapper);
                    break;
                case 2:
                    $validator = $app->getContainer()->get('validator');
                    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
                    $cleaned_parameters = $project_overview_model->cleanParameters($validator, $input_parameters);
                    $user = $project_overview_model->findUser($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters, $bcrypt_wrapper);

                    if (!empty($user)) {
                        $_SESSION['logged_in'] = "Yes";
                        $_SESSION['user'] = $user['first_name'] . " " . $user['last_name'];
                        $_SESSION['first_name'] = $user['first_name'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['clearance'] = $user['clearance'];
                        if ($_SESSION['clearance'] > 2) {
                            $project_array = $project_overview_model->retrieveAllProjects($db_connection_settings, $sql_queries, $db_wrapper);
                        } else {
                            $project_array = $project_overview_model->retrieveRelevantProjects($db_connection_settings, $sql_queries, $db_wrapper, $user['username']);
                        }
                    }
                    break;
                case 3:
                    $cleaned_parameters = $project_overview_model->cleanProjectParameters($validator, $input_parameters);
                    $project_overview_model->storeNewProject($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters, $_SESSION['user']);
                    $project_array = $project_overview_model->retrieveAllProjects($db_connection_settings, $sql_queries, $db_wrapper);
                    break;
                case 4:
                    $cleaned_parameters = $project_overview_model->cleanProjectParameters($validator, $input_parameters);
                    $project_overview_model->updateProject($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters);
                    $project_array = $project_overview_model->retrieveAllProjects($db_connection_settings, $sql_queries, $db_wrapper);
                    break;
                default:
                    break;
            }

            if (isset($_SESSION['first_name'])) {
                $project_overview_view->createProjectOverviewView($view, $response, $_SESSION['first_name'], $project_array);
            } else {
                $project_overview_view->createProjectOverviewView($view, $response, "", $project_array);
            }

        } else {
            $project_overview_view->createViewError($view, $response);
        }
    }

    /**
     * Method createHtmlOutputStart
     * This method creates an HTML output to display the form that allows to start a new project.
     *
     * @param $app 'The SLIM application defined in settings.php'
     * @param $request 'The request from the user sent as parameter'
     * @param $response 'The response to be handled when view is processed'
     * @return void 'Return the web page'
     *
     */
    public function createHtmlOutputStart($app, $request, $response)
    {
        $view = $app->getContainer()->get('view');
        $start_project_view = $app->getContainer()->get('projectOverviewView');
        $start_project_model = $app->getContainer()->get('projectOverviewModel');

        $db_wrapper = $app->getContainer()->get('databaseWrapper');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        if (!empty($_SESSION)) {
            $stakeholder_array = $start_project_model->retrieveStakeholders($db_connection_settings, $sql_queries, $db_wrapper);

            $start_project_view->createStartProjectView($view, $response, $stakeholder_array);
        } else {
            $start_project_view->createViewError($view, $response);
        }

    }

    /**
     * Method createHtmlOutputEdit
     * This method creates an HTML output to display the form that allows to edit the project details.
     *
     * @param $app 'The SLIM application defined in settings.php'
     * @param $request 'The request from the user sent as parameter'
     * @param $response 'The response to be handled when view is processed'
     * @return void 'Return the web page'
     *
     */
    public function createHtmlOutputEdit($app, $request, $response)
    {
        $view = $app->getContainer()->get('view');
        $edit_project_view = $app->getContainer()->get('projectOverviewView');
        $edit_project_model = $app->getContainer()->get('projectOverviewModel');

        $db_wrapper = $app->getContainer()->get('databaseWrapper');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        if (!empty($_SESSION)) {
            $stakeholder_array = $edit_project_model->retrieveStakeholders($db_connection_settings, $sql_queries, $db_wrapper);

            $edit_project_view->createEditProjectView($view, $response, $stakeholder_array);
        } else {
            $edit_project_view->createViewError($view, $response);
        }
    }

    /**
     * Method createHtmlOutputDelete
     * This method creates an HTML output to display the form that allows to delete the selected project.
     *
     * @param $app 'The SLIM application defined in settings.php'
     * @param $request 'The request from the user sent as parameter'
     * @param $response 'The response to be handled when view is processed'
     * @return void 'Return the web page'
     *
     */
    public function createHtmlOutputDelete($app, $request, $response)
    {
        $view = $app->getContainer()->get('view');
        $delete_project_view = $app->getContainer()->get('projectOverviewView');

        if (!empty($_SESSION)) {
            $delete_project_view->createDeleteProjectView($view, $response);
        } else {
            $delete_project_view->createViewError($view, $response);
        }
    }
}