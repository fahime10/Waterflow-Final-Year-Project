<?php
/**
 * SendEmailView.php
 *
 * This class uses createSendEmail to display the form for the user to complete.
 *
 */
namespace Waterflow\View;

class SendEmailView
{
    public function __construct() {}
    public function __destruct() {}

    /**
     * Method createSendEmailView
     * This method uses a Twig template to produce the form that is used to send the email.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createSendEmailView($view, $response)
    {
        $view->render(
            $response,
            'send_email.html.twig',
            [
                'action' => 'result_email',
                'method' => 'post',
                'clearance' => $_SESSION['clearance'],
                'title' => APP_NAME,
                'email_address' => EMAIL_USERNAME,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO,
                'return_to_projects' => 'project_overview'
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