<?php
/**
 * ResultChangeModel.php
 *
 * This class uses createResultChange to display the result of the password change.
 *
 */
namespace Waterflow\View;

class ResultChangeView
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * Method createResultChangeView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $result 'Result of the change'
     * @return void 'The HTML view'
     *
     */
    public function createResultChangeView($view, $response, $result)
    {
        if ($result == "Successful") {
            $html_output = "<p>Your password has been successfully changed</p>";

        } else {
            $html_output = "<p>Your request was not successful, please try again or contact the relevant manager</p>";

        }
        $view->render(
            $response,
            'result_change.html.twig',
            [
                'title' => APP_NAME,
                'message' => $html_output,
                'pathway' => $_SERVER['SCRIPT_NAME'],
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );

    }
}