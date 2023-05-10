<?php
/**
 * ViewReportsController.php
 *
 * This class uses createHtmlOutput to display a list of all finished projects.
 * Each element in the list is a link to the text file.
 *
 */
namespace Waterflow\Controller;

class ViewReportsController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and ViewReportsView.
     * Since the method uses scandir(), it is necessary for the application to ignore the dots, as they act as
     * 'change directory' in the terminal when pressed.
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

        $view_reports_view = $app->getContainer()->get('viewReportsView');

        if (!empty($_SESSION)) {
            $folder_path = FOLDER_PATH;

            $text_files = scandir($folder_path);

            $reports = [];

            foreach ($text_files as $file) {
                if ($file != "." && $file != "..") {
                    array_push($reports, substr($file, 0, strlen($file) - 4));
                }
            }

            $view_reports_view->createViewReportsView($view, $response, $reports);
        } else {
            $view_reports_view->createViewError($view, $response);
        }

    }
}