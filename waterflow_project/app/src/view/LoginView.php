<?php
/**
 * LoginView.php
 *
 * This class uses createLoginPageView to display the interface of the login page.
 *
 */
namespace Waterflow\View;

class LoginView
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * Method createLoginPageView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createLoginPageView($view, $response)
    {
        $view->render(
            $response,
            'login.html.twig',
            [
                'css_login_path' => LOGIN_PATH,
                'action' => 'project_overview',
                'title' => APP_NAME,
                'action_password' => 'change_password',
                'logo' => LOGO
            ]
        );
    }

    /**
     * Method createLogoutView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createLogoutView($view, $response)
    {

        if (empty($_SESSION)) {
            $message = "<p>Successfully logged out!</p>";
            $message .= "<p>You can safely close the browser or get back to the login page.</p>";

        } else {
            $message = "<p>Sorry, something went wrong...</p>";
            $message .= "<p>Please close the browser and try logging in again.</p>";
        }

        $view->render(
            $response,
            'logout.html.twig',
            [
                'css_styles' => STYLES_PATH,
                'action' => FIRST_PAGE,
                'title' => APP_NAME,
                'logo' => LOGO,
                'message' => $message
            ]
        );
    }
}