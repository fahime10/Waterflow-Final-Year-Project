<?php
/**
 * ViewReportsView.php
 *
 * This class uses createViewReportsView to display a list of reports of the finished projects.
 *
 */
namespace Waterflow\View;

class ViewReportsView
{
    public function __construct() {}
    public function __destruct() {}

    /**
     * Method createViewReportsView
     * This method uses a Twig template to produce the list of reports.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $reports 'Array of reports'
     * @return void
     *
     */
    public function createViewReportsView($view, $response, $reports) {

        $html_output = "<form action='display_report' method='post'>
                            <ul>";

        foreach ($reports as $report) {
            $html_output .= "
                            <li><button name='$report'>$report</button></li>";
        }

        $html_output .= "</ul>
                    </form>";

        $view->render(
            $response,
            'view_reports.html.twig',
            [
                'action_view' => 'display_report',
                'return_to_projects' => 'project_overview',
                'method' => 'post',
                'title' => APP_NAME,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO,
                'reports' => $html_output
            ]
        );
    }

    /**
     * Method createErrorView
     * This method creates an error page.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void
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