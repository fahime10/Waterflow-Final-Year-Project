<?php
/**
 * ResultChangeModel.php
 *
 * This class uses a series of method to connect to the database and change a user's password.
 *
 */
namespace Waterflow\Model;

class ResultChangeModel
{
    private $db_wrapper;
    private $sql_queries;
    private $db_connection_settings;

    /**
     * Method __construct
     * This method sets the initial values to null for the variables.
     *
     */
    public function __construct()
    {
        $this->db_wrapper = null;
        $this->sql_queries = null;
        $this->db_connection_settings = null;
    }

    public function __destruct() {}

    /**
     * Method setDatabaseWrapper
     * This method sets the database wrapper instance in this variable.
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return void
     *
     */
    public function setDatabaseWrapper($db_wrapper)
    {
        $this->db_wrapper = $db_wrapper;
    }

    /**
     * Method setDatabaseConnectionSettings
     * This method sets the database connection settings in this variable.
     *
     * @param $db_connection_settings 'Database settings defined by user'
     * @return void
     *
     */
    public function setDatabaseConnectionSettings($db_connection_settings)
    {
        $this->db_connection_settings = $db_connection_settings;
    }

    /**
     * Method setSqlQueries
     * This method sets the sql queries instance in this variable.
     *
     * @param $sql_queries 'SqlQueries instance'
     * @return void
     *
     */
    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    /**
     * Method cleanParameters
     * This method validates and sanitises data from the user.
     *
     * @param $validator 'Validator instance'
     * @param $tainted_parameters 'Inputted data from user'
     * @return array 'Return validated data'
     *
     */
    public function cleanParameters($validator, $tainted_parameters): array
    {
        $cleaned_parameters = [];

        $tainted_username = $tainted_parameters['username'];

        $cleaned_parameters['sanitised_username'] = $validator->sanitiseString($tainted_username);
        $cleaned_parameters['sanitised_password'] = $tainted_parameters['password'];

        return $cleaned_parameters;
    }

    /**
     * Method changeUserPassword
     * This method runs a query to change a user's password.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $cleaned_parameters 'Array of parameters'
     * @param $bcrypt_wrapper 'BcryptWrapper instance'
     * @return string 'Return result of changed password'
     */
    public function changeUserPassword($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters, $bcrypt_wrapper)
    {
        $query_string = $sql_queries->retrieveUser();

        $query_parameters = [
            ':username' => $cleaned_parameters['sanitised_username']
        ];

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, $query_parameters);

        $find_row = $this->db_wrapper->safeFetchRow();

        $username = "";

        if ($find_row) {
            $username = $find_row[3];
        }

        if ($username == $cleaned_parameters['sanitised_username']) {
             $new_password = $bcrypt_wrapper->createHashPassword($cleaned_parameters['sanitised_password']);

             $second_query_string = $sql_queries->changePassword();

             $second_query_parameters = [
                 ':username' => $username,
                 ':password' => $new_password
             ];

            $this->setDatabaseWrapper($db_wrapper);
            $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
            $this->db_wrapper->connectDatabase();
            $this->db_wrapper->safeQuery($second_query_string, $second_query_parameters);

            $result = "Successful";

        } else {
            $result = "Unsuccessful";
        }

        return $result;
    }
}