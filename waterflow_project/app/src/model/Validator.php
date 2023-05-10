<?php
/**
 * Validator.php
 *
 * This class uses methods to sanitise strings and emails.
 *
 */
namespace Waterflow\Model;

class Validator
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * Method sanitiseString
     * This method sanitises string using the PHP function filter_var().
     *
     * @param $string 'String to be sanitised'
     * @return false|mixed 'Return sanitised string, false otherwise'
     *
     */
    public function sanitiseString($string)
    {
        $sanitised_string = false;

        if(!empty($string)) {
            $sanitised_string = filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
        return $sanitised_string;
    }

    /**
     * Method sanitiseEmail
     * This method sanitises emails using the PHP function filter_var().
     *
     * @param $email 'Email to be sanitised'
     * @return false|mixed 'Return sanitised email, false otherwise'
     *
     */
    public function sanitiseEmail($email)
    {
        $sanitised_email = false;

        if(!empty($email)) {
            $sanitised_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        }

        return $sanitised_email;
    }
}
