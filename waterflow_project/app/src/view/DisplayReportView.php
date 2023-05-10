<?php
/**
 * DisplayReportView.php
 *
 * This class uses createDisplayReportView to provide the user with a view of the chosen report.
 *
 */
namespace Waterflow\View;

class DisplayReportView
{
    public function __construct() {}
    public function __destruct() {}

    /**
     * This method uses a Twig template to produce the view.
     * It also requires the name of the file and its contents to save it in the application.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $file_name 'Name of the file'
     * @param $file 'Content of the file'
     * @return void 'The HTML view'
     *
     */
    public function createDisplayReportView($view, $response, $file_name, $file)
    {

        $html_output = "<pre>
                            $file
                        </pre>";

        $view->render(
            $response,
            'display_report.html.twig',
            [
                'return_to_view_reports' => 'view_reports',
                'css_styles' => STYLES_PATH,
                'logo' => LOGO,
                'method' => 'post',
                'project_name' => $file_name,
                'report' => $html_output
            ]
        );
    }

    /**
     * Method createErrorView
     * This method creates an error page.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createViewError($view, $response)
    {
        $view->render(
            $response,
            'error_view.html.twig',
            [
                'title' => APP_NAME,
                'css_styles' => STYLES_PATH,
                'first_page' => FIRST_PAGE,
                'logo' => LOGO
            ]
        );
    }
}