<?php
/**
 * ChangePasswordView.php
 *
 * This class uses createChangePasswordView to provide the user with a form to change their password.
 *
 */
namespace Waterflow\View;

class ChangePasswordView
{
    public function __construct(){}
    public function __destruct(){}

    /**
     * Method createChangePasswordView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createChangePasswordView($view, $response)
    {
        $view->render(
            $response,
            'change_password.html.twig',
            [
                'title' => APP_NAME,
                'action' => 'result_change',
                'method' => 'post',
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }
}