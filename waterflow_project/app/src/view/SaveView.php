<?php
/**
 * SaveView.php
 *
 * This class uses createSaveView to display the progress of the tasks being saved.
 *
 */
namespace Waterflow\View;

class SaveView
{
    public function __construct(){}
    public function __destruct(){}

    /**
     * Method createSaveView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $project_id 'Project id'
     * @return void 'The HTML view'
     *
     */
    public function createSaveView($view, $response, $project_id)
    {
        $view->render(
            $response,
            'save_progress.html.twig',
            [
                'title' => APP_NAME,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO,
                'action' => 'task_overview',
                'method' => 'post',
                'project_id' => $_SESSION['project_id']
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