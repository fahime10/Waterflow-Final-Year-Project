<?php
/**
 * TaskOverviewController.php
 *
 * This class uses a series of functions to produce an HTML output according to user's request using instances of
 * TaskOverviewModel and TaskOverviewView class.
 * The first pathway function is about displaying relevant tasks, depending on which project has been selected.
 *
 * The other pathways functions display forms for add, edit and delete of a task.
 *
 */
namespace Waterflow\Controller;

class TaskOverviewController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML using an instance of view and TaskOverviewView class.
     * The model class, TaskOverviewModel, uses instances of DatabaseWrapper, SqlQueries and Validator to validate data
     * and to handle different queries depending upon the number of input parameters from the user.
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

        $task_overview_model = $app->getContainer()->get('taskOverviewModel');
        $task_overview_view = $app->getContainer()->get('taskOverviewView');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        $count_parameters = count($input_parameters);

        $check_finished = false;


        if (isset($_SESSION['first_name']) && isset($_SESSION['project_id']) && empty($input_parameters['task_id']) &&
            empty($input_parameters['task_description'])) {

            $_SESSION['project_id'] = (int)$input_parameters['project_id_task'];
            $check_finished = $task_overview_model->checkFinished($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters['project_id_task']);
            $task_array = $task_overview_model->retrieveAllTasks($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters['project_id_task']);
            $task_overview_view->createTaskOverviewView($view, $response, $task_array, $check_finished);

        } else if ($count_parameters > 0 && !empty($_SESSION)) {
            if (!empty($input_parameters['project_id_task'])) {
                $_SESSION['project_id'] = (int)$input_parameters['project_id_task'];
                $check_finished = $task_overview_model->checkFinished($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters['project_id_task']);
            }
            switch ($count_parameters) {
                case 1:
                    break;
                case 2:
                    $task_overview_model->deleteTask($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters);
                    break;
                case 4:
                    $cleaned_parameters = $task_overview_model->cleanTaskParameters($validator, $input_parameters);
                    $task_overview_model->storeNewTask($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters);
                    break;
                case 5:
                    $cleaned_parameters = $task_overview_model->cleanTaskParameters($validator, $input_parameters);
                    $task_overview_model->updateTask($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters);
            }

            $task_array = $task_overview_model->retrieveAllTasks($db_connection_settings, $sql_queries, $db_wrapper, $_SESSION['project_id']);
            $task_overview_view->createTaskOverviewView($view, $response, $task_array, $check_finished);

        } else {
            $task_overview_view->createViewError($view, $response);
        }
    }

    /**
     * Method createHtmlOutputAdd
     * This method creates an HTML output to display a form that allows to add a task.
     *
     * @param $app 'The SLIM application defined in settings.php'
     * @param $request 'The request from the user sent as parameter'
     * @param $response 'The response to be handled when view is processed'
     * @return void 'Return the web page'
     *
     */
    public function createHtmlOutputAdd($app, $request, $response)
    {
        $view = $app->getContainer()->get('view');
        $add_task_view = $app->getContainer()->get('taskOverviewView');
        $add_task_model = $app->getContainer()->get('taskOverviewModel');

        $db_wrapper = $app->getContainer()->get('databaseWrapper');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        if (!empty($_SESSION)) {
            $users = $add_task_model->retrieveAllUsers($db_connection_settings, $sql_queries, $db_wrapper);
            $teams = $add_task_model->retrieveAllTeams($db_connection_settings, $sql_queries, $db_wrapper);

            $add_task_view->createAddTaskView($view, $response, $users, $teams);
        } else {
            $add_task_view->createViewError($view, $response);
        }
    }

    /**
     * Method createHtmlOutputEdit
     * This method creates an HTML output to display a form that allows to edit a selected task.
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
        $edit_task_view = $app->getContainer()->get('taskOverviewView');
        $edit_task_model = $app->getContainer()->get('taskOverviewModel');

        $db_wrapper = $app->getContainer()->get('databaseWrapper');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        if (!empty($_SESSION)) {
            $users = $edit_task_model->retrieveAllUsers($db_connection_settings, $sql_queries, $db_wrapper);
            $teams = $edit_task_model->retrieveAllTeams($db_connection_settings, $sql_queries, $db_wrapper);

            $edit_task_view->createEditTaskView($view, $response, $users, $teams);
        } else {
            $edit_task_view->createViewError($view, $response);
        }
    }

    /**
     * Method createHtmlOutputDelete
     * This method creates an HTML output to display a form that allows to delete a selected task.
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
        $delete_task_view = $app->getContainer()->get('taskOverviewView');

        if (!empty($_SESSION)) {
            $delete_task_view->createDeleteTaskView($view, $response);
        } else {
            $delete_task_view->createViewError($view, $response);
        }
    }
}