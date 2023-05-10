<?php
/**
 * ManageUsersController.php
 *
 * This class uses a series of functions to produce an HTML output according to user's request using instances of
 * ManageUsersModel and ManageUsersView class.
 * The first pathway is about displaying users and teams stored in the database.
 * The other pathways display the forms for add, edit and delete of a user.
 *
 */
namespace Waterflow\Controller;

class ManageUsersController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and ManageUsersView.
     * The model class, ManageUsersModel, uses instances of DatabaseWrapper and SqlQueries to retrieve all users and
     * teams from the database.
     * It also handles different queries according to the number of input parameters requested from a previous page.
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

        $manage_users_model = $app->getContainer()->get('manageUsersModel');
        $manage_users_view = $app->getContainer()->get('manageUsersView');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        $count_parameters = count($input_parameters);

        $user_array = [];
        $team_array = [];

        if (isset($_SESSION['first_name']) && empty($input_parameters['username']) && empty($input_parameters['user_id'])) {
            $user_array = $manage_users_model->getAllUsers($db_connection_settings, $sql_queries, $db_wrapper);
            $team_array = $manage_users_model->getAllTeams($db_connection_settings, $sql_queries, $db_wrapper);
            $manage_users_view->createManageUsersView($view, $response, $user_array, $team_array);

        } else if ($count_parameters > 0 && (!empty($_SESSION))) {
            switch ($count_parameters) {
                case 1:
                    $manage_users_model->deleteUser($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters);
                    $user_array = $manage_users_model->getAllUsers($db_connection_settings, $sql_queries, $db_wrapper);
                    $team_array = $manage_users_model->getAllTeams($db_connection_settings, $sql_queries, $db_wrapper);
                    break;

                case 5:
                    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
                    $manage_users_model->storeNewUser($db_connection_settings, $sql_queries, $db_wrapper, $bcrypt_wrapper, $input_parameters);
                    $user_array = $manage_users_model->getAllUsers($db_connection_settings, $sql_queries, $db_wrapper);
                    $team_array = $manage_users_model->getAllTeams($db_connection_settings, $sql_queries, $db_wrapper);
                    break;

                case 6:
                    $manage_users_model->updateUser($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters);
                    $user_array = $manage_users_model->getAllUsers($db_connection_settings, $sql_queries, $db_wrapper);
                    $team_array = $manage_users_model->getAllTeams($db_connection_settings, $sql_queries, $db_wrapper);
                    break;
                default:
                    break;
            }

            $manage_users_view->createManageUsersView($view, $response, $user_array, $team_array);
        } else {
            $manage_users_view->createViewError($view, $response);
        }
    }

    /**
     * Method createHtmlOutputAdd
     * This method produces an HTML output for displaying the form that allows to add the user.
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
        $manage_users_view = $app->getContainer()->get('manageUsersView');

        if (!empty($_SESSION)) {
            $manage_users_view->createAddUserView($view, $response);
        } else {
            $manage_users_view->createViewError($view, $response);
        }
    }

    /**
     * Method createHtmlOutputEdit
     * This method produces an HTML output for displaying the form that allows to edit a selected user.
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
        $edit_user_view = $app->getContainer()->get('manageUsersView');

        if (!empty($_SESSION)) {
            $edit_user_view->createEditUserView($view, $response);
        } else {
            $edit_user_view->createViewError($view, $response);
        }
    }

    /**
     * Method createHtmlOutputDelete
     * This method produces an HTML output to display the form that allows to delete a selected user.
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
        $delete_user_view = $app->getContainer()->get('manageUsersView');

        if (!empty($_SESSION)) {
            $delete_user_view->createDeleteUserView($view, $response);
        } else {
            $delete_user_view->createViewError($view, $response);
        }
    }
}