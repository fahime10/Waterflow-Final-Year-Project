<?php
/**
 * BcryptWrapper.php
 *
 * This class uses functions to hash a password and to authenticate passwords.
 *
 */
namespace Waterflow\Framework;

class BcryptWrapper
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * Method createHashPassword
     * This method takes the inputted password from the user and hashes it using the provided algorithm and cost.
     * This is very useful when storing the password as hashed string rather than plan text.
     * The PHP function used is password_hash().
     *
     * @param $password 'User inputted password'
     * @return false|string|null 'Return a hashed string or empty string'
     *
     */
    public function createHashPassword($password)
    {
        $password_string = $password;
        $bcrypt_hash_password = '';

        if (!empty($password_string))
        {
            $options = array('cost' => (BCRYPT_COST));
            $bcrypt_hash_password = password_hash($password_string, BCRYPT_ALGO, $options);
        }
        return $bcrypt_hash_password;
    }

    /**
     * Method authenticatePassword
     * This method uses passsword_verify() to compare the plain text password and the hashed password that is stored
     * in the database.
     *
     * @param $password_string 'Plain text password'
     * @param $stored_password_hash 'Hashed password from the database'
     * @return bool 'Return true if password match, false otherwise'
     *
     */
    public function authenticatePassword($password_string, $stored_password_hash): bool
    {
        $user_authenticated = false;
        $current_stored_password = $password_string;

        if (!empty($current_stored_password) && !empty($stored_password_hash))
        {
            if (password_verify($current_stored_password, $stored_password_hash))
            {
                $user_authenticated = true;
            }
        }
        return $user_authenticated;
    }

    /**
     * Method createHashPassword
     * This method takes the inputted password from the user and hashes it using the provided algorithm and cost.
     * This method is only used for a PHPUnit test case to bypass the error "Undefined BCRYPT ALGO".
     *
     * @param $password 'User inputted password'
     * @return false|string|null 'Return a hashed string or empty string'
     *
     */
    public function hashPassword($password) {
        $password_string = $password;
        $bcrypt_hash_password = '';

        if (!empty($password_string))
        {
            $options = array('cost' => (12));
            $bcrypt_hash_password = password_hash($password_string, "2y", $options);
        }
        return $bcrypt_hash_password;
    }
}