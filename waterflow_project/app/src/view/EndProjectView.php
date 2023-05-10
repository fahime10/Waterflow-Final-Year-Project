<?php
/**
 * EndProjectView.php
 *
 * This class uses createEndProjectView to create the view with a full report of the project's tasks.
 *
 */
namespace Waterflow\View;

class EndProjectView
{
    public function __construct() {}
    public function __destruct() {}

    /**
     * Method createEndProjectView
     * This method uses a Twig template to produce the view.
     * It also requires the result, which is the content of the report.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $result 'Content of the finished project'
     * @return void 'The HTML view'
     *
     */
    public function createEndProjectView($view, $response, $result)
    {
        $view->render(
          $response,
          'end_project.html.twig',
          [
              'title' => APP_NAME,
              'css_styles' => STYLES_PATH,
              'logo' => LOGO,
              'action' => "project_overview",
              'method' => 'post',
              'report' => $result
          ]
        );
    }
}