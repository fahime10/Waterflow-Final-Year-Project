<?php
/**
 * DisplayReportController.php
 *
 * This class uses createHtmlOutput to create an HTML output for the user to see the selected report.
 *
 */
namespace Waterflow\Controller;

class DisplayReportController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and DisplayReportView class.
     * The goal is to access the application's folder to view the selected text file.
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

        $display_report_view = $app->getContainer()->get('displayReportView');

        if (!empty($_SESSION)) {
            $file_name = array_keys($input_parameters);

            $file_path = FOLDER_PATH . $file_name[0] . ".txt";

            $open_file = file_get_contents($file_path, true);

            $display_report_view->createDisplayReportView($view, $response, $file_name[0], $open_file);
        } else {
            $display_report_view->createViewError($view, $response);
        }
    }
}