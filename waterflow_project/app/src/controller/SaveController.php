<?php
/**
 * SaveController.php
 *
 * This class uses createHtmlOutput to display that the tasks' progress are being saved in the database.
 *
 */
namespace Waterflow\Controller;

class SaveController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and SaveView class.
     * The model class, TaskOverviewModel, uses instances of DatabaseWrapper and SqlQueries to set the relevant tasks
     * as either completed or not completed in the database.
     *
     * @param $app 'The SLIM application defined in settings.php'
     * @param $request 'The request from the user sent as parameter'
     * @param $response 'The response to be handled when view is processed'
     * @return void 'Return the web page'
     *
     */
    public function createHtmlOutput($app, $request, $response)
    {
        $view = $app->getContainer()->get('view');
        $save_view = $app->getContainer()->get('saveView');

        if (!empty($_SESSION)) {
            $input_parameters = $request->getParsedBody();

            $db_wrapper = $app->getContainer()->get('databaseWrapper');

            $task_overview_model = $app->getContainer()->get('taskOverviewModel');

            $db_conf = $app->getContainer()->get('settings');
            $db_connection_settings = $db_conf['pdo_settings'];
            $sql_queries = $app->getContainer()->get('sqlQueries');

            if (isset($input_parameters['project_id_task'])) {
                $project_id = (int)$input_parameters['project_id_task'];
            } else {
                $project_id = 0;
            }


            $task_overview_model->saveProgress($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters);

            $save_view->createSaveView($view, $response, $project_id);
        } else {
            $save_view->createViewError($view, $response);
        }

    }
}