<?php
/**
 * SendEmailController.php
 *
 * This class uses createHtmlOutput to produce a form for the user to complete and to send the email.
 *
 */
namespace Waterflow\Controller;

class SendEmailController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and SendEmailView.
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

        $send_email_view = $app->getContainer()->get('sendEmailView');

        if (!empty($_SESSION)) {
            $send_email_view->createSendEmailView($view, $response);
        } else {
            $send_email_view->createViewError($view, $response);
        }
    }
}