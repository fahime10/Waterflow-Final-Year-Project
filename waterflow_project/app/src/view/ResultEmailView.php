<?php
/**
 * ResultEmailView.php
 *
 * This class uses createResultEmailView to display the result of the email.
 *
 */
namespace Waterflow\View;

class ResultEmailView
{
    public function __construct() {}
    public function __destruct() {}

    /**
     * Method createResultEmailView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $email 'The email to be sent'
     * @return void 'The HTML view'
     *
     */
    public function createResultEmailView($view, $response, $email)
    {
        $html_output = "<p>Recipient: {$email['recipient']}</p>";
        $html_output .= "<p>Subject: {$email['subject']}</p>";
        $html_output .= "<p>Message: {$email['message']}</p>";

        $view->render(
            $response,
            'result_email.html.twig',
            [
                'title' => APP_NAME,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO,
                'action' => 'project_overview',
                'method' => 'post',
                'email' => $html_output
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