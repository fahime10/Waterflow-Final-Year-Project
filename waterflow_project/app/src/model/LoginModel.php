<?php
/**
 * LoginModel.php
 *
 * This class uses deleteSession to unset and destroy an existing session.
 *
 */
namespace Waterflow\Model;

class LoginModel
{
    public function __construct() {}
    public function __destruct() {}

    /**
     * Method deleteSession
     * This method unsets and destroys a session.
     *
     * @return void
     *
     */
    public function deleteSession()
    {
        unset($_SESSION);
        session_destroy();
        session_unset();
    }
}