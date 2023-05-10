<?php
/**
 * ChangePasswordController.php
 *
 * This class uses createHtmlOutput to create an HTML output for changing user's password.
 *
 */
namespace Waterflow\Controller;

class ChangePasswordController
{
    /**
     * Method createHtmlOutput
     * This method returns an HTML output using an instance of the view and the ChangePasswordView class.
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
        $change_password_view = $app->getContainer()->get('changePasswordView');

        $change_password_view->createChangePasswordView($view, $response);
    }
}