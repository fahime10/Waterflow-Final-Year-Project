<?php
/**
 * LoginController.php
 *
 * This class uses createHtmlOutput to create an HTML output using an instance of view and LoginView.
 *
 */
namespace Waterflow\Controller;

class LoginController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and LoginView.
     * The method will attempt to delete a running session if it exists.
     * Depending on whethere there was an existing session or not, the method will attempt to use the correct LoginView
     * method for the purpose, whether it's login or logout page.
     *
     * @param $app 'The SLIM application defined in settings.php'
     * @param $request 'The request from the user sent as parameter'
     * @param $response 'The response to be handled when view is processed'
     * @return void 'Return the correct web page'
     *
     */
    public function createHtmlOutput($app, $request, $response)
    {
        $view = $app->getContainer()->get('view');
        $login_view = $app->getContainer()->get('loginView');
        $login_model = $app->getContainer()->get('loginModel');

        if (!empty($_SESSION)) {
            $login_model->deleteSession();

            $login_view->createLogoutView($view, $response);

        } else {
            $_SESSION['logged_in'] = "No";

            $login_view->createLoginPageView($view, $response);
        }
    }
}
