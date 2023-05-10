<?php
/**
 * SessionWrapper.php
 *
 * This class uses a series of functions to handle sessions.
 *
 */
namespace Waterflow\Framework;

class SessionWrapper
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * Method setSessionKey
     * This method sets the session key.
     *
     * @param $sessionKey 'Session key defined by user, the key of the associative array'
     * @param $sessionValue 'Session value defined by user, the value associated to the key'
     * @return bool 'Return true if successfully set, false otherwise'
     */
    public function setSessionKey($sessionKey, $sessionValue)
    {
        $sessionValueSuccessful = false;

        if (!empty($sessionValue)) {
            $_SESSION[$sessionKey] = $sessionValue;
            if (strcmp($_SESSION[$sessionKey], $sessionValue) == 0) {
                $sessionValueSuccessful = true;
            }
        }

        return $sessionValueSuccessful;
    }

    /**
     * Method getSessionKey
     * This method retrieves the session value from a given key.
     *
     * @param $sessionKey 'Session key defined by user'
     * @return false|mixed 'Return the value, false otherwise'
     *
     */
    public function getSessionValue($sessionKey)
    {
        $sessionValue = false;

        if (isset($_SESSION[$sessionKey])) {
            $sessionValue = $_SESSION[$sessionKey];
        }

        return $sessionValue;
    }

    /**
     * Method unsetSessionKey
     * This method unsets a key defined by the user.
     *
     * @param $sessionKey 'Session key defined by user'
     * @return bool 'Return true if session key has been unset, false otherwise'
     *
     */
    public function unsetSessionKey($sessionKey)
    {
        $unsetSession = false;

        if (isset($_SESSION[$sessionKey])) {
            unset($_SESSION[$sessionKey]);
            $unsetSession = true;
        }

        return $unsetSession;
    }
}
