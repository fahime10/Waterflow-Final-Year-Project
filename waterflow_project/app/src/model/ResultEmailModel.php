<?php
/**
 * ResultEmailModel.php
 *
 * This class uses a series of function to validate data and send an email.
 *
 */
namespace Waterflow\Model;

class ResultEmailModel
{
    /**
     * Method cleanParameters
     * This method validates and sanitises the email.
     *
     * @param $validator 'Validator instance'
     * @param $input_parameters 'Values to validate'
     * @return array 'Return an array with validated data'
     *
     */
    public function cleanParameters($validator, $input_parameters): array
    {
        $cleaned_parameters = [];

        $tainted_recipient = $input_parameters['recipient'];
        $tainted_subject = $input_parameters['subject'];
        $tainted_message = $input_parameters['message'];

        $cleaned_parameters['recipient'] = $validator->sanitiseEmail($tainted_recipient);
        $cleaned_parameters['subject'] = $validator->sanitiseString($tainted_subject);
        $cleaned_parameters['message'] = $validator->sanitiseString($tainted_message);

        return $cleaned_parameters;
    }

    /**
     * Method sendEmail
     * This method sends an email using the PHP mail() function.
     *
     * @param $cleaned_parameters 'Array of parameters'
     * @return bool 'Return true if email is accepted for sending, false otherwise'
     *
     */
    public function sendEmail($cleaned_parameters): bool
    {
        $recipient = $cleaned_parameters['recipient'];

        $subject = $cleaned_parameters['subject'];

        $message = $cleaned_parameters['message'];

        $headers = "From: " . $cleaned_parameters['sender'];

         return mail($recipient, $subject, $message, $headers);
    }
}