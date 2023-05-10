<?php
/**
 * ResultEmailController.php
 *
 * This class uses createHtmlOutput to display the result of the sent email.
 *
 */
namespace Waterflow\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ResultEmailController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and ResultEmailView.
     * This method uses PHPMailer to envelope the email and send it to the required recipient.
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
        $result_email_view = $app->getContainer()->get('resultEmailView');

        if (!empty($_SESSION)) {
            $input_parameters = $request->getParsedBody();

            $validator = $app->getContainer()->get('validator');

            $result_email_model = $app->getContainer()->get('resultEmailModel');

            $cleaned_parameters = $result_email_model->cleanParameters($validator, $input_parameters);

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = "smtp-mail.outlook.com";
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = "tls";
                $mail->Username   = EMAIL_USERNAME;
                $mail->Password   = EMAIL_PASSWORD;
                $mail->Port       = 587;

                //Recipients
                $mail->setFrom(EMAIL_USERNAME, EMAIL_USERNAME);
                $mail->addAddress($cleaned_parameters['recipient'], $cleaned_parameters['recipient']);

                $mail->Subject = $cleaned_parameters['subject'];
                $mail->Body    = $cleaned_parameters['message'];

                $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error...";
            }

            $result_email_view->createResultEmailView($view, $response, $cleaned_parameters);
        } else {
            $result_email_view->createViewError($view, $response);
        }
    }

}