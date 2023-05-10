<?php
/**
 * EndProjectController.php
 *
 * This class uses createHtmlOutput to create an HTML output to allow the user to declare the end of a project
 * and view the text file for that project.
 *
 */
namespace Waterflow\Controller;

class EndProjectController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and EndProjectView.
     *
     * The function attempts to first check if a text file with the same title exists.
     * If the file name does not exist, then the function uses an instance of EndProjectModel to set all the tasks to
     * "completed" and set the project as "finished". It then retrieves some useful information to retrieve project
     * information, including all the tasks involved and the client's name.
     * This information will be used to create the report text file.
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
        $end_project_model = $app->getContainer()->get('endProjectModel');
        $end_project_view = $app->getContainer()->get('endProjectView');

        $validator = $app->getContainer()->get('validator');

        $project_name = $end_project_model->cleanParameters($validator, $input_parameters);

        for ($i = 0; $i < strlen($project_name); $i++) {
            if ($project_name[$i] === " ") {
                $project_name[$i] = "_";
            }
        }

        $file_path = FOLDER_PATH . $project_name . ".txt";

        if (!file_exists($file_path)) {

            $db_wrapper = $app->getContainer()->get('databaseWrapper');

            $db_conf = $app->getContainer()->get('settings');
            $db_connection_settings = $db_conf['pdo_settings'];
            $sql_queries = $app->getContainer()->get('sqlQueries');

            $end_project_model->completeAllTasks($db_connection_settings, $sql_queries, $db_wrapper);
            $end_project_model->setProjectFinished($db_connection_settings, $sql_queries, $db_wrapper);

            $project = $end_project_model->retrieveProjectDetails($db_connection_settings, $sql_queries, $db_wrapper);
            $project_client = $end_project_model->findProjectClient($db_connection_settings, $sql_queries, $db_wrapper, $project['project_client']);

            $header = "Project Title: " . $project['project_name'] . "\n";
            $header .= "Initiated by " . $project['project_manager'] . "\n";
            $header .= "Project client is: " . $project_client[0] . " " . $project_client[1] . "\n";
            $header .= "Project finished date: " . date("j/m/Y");

            $all_tasks = $end_project_model->retrieveAllTasks($db_connection_settings, $sql_queries, $db_wrapper);

            $tasks = "Tasks completed: \n--------------------------------------\n";
            foreach ($all_tasks as $task) {
                $tasks .= "Name of the task: $task[2]\n";
                $tasks .= "Completed by $task[3]\n";
                $tasks .= "Successfully completed by the date $task[4]\n\n";
            }

            $whole_document = $header . "\n\n" . $tasks;

            $new_file = fopen($file_path, "w+");
            fwrite($new_file, $whole_document);
            $result = file_get_contents($file_path, true);

        } else {
            $result =  "Sorry, file name already exists!\nPlease rename the file...";
        }

        $end_project_view->createEndProjectView($view, $response, $result);
    }
}