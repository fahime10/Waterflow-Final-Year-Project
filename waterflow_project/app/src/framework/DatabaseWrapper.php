<?php
/**
 * DatabaseWrapper.php
 *
 * This class provides a series of method to connect to the database and run desired queries defined by the user.
 *
 */
namespace Waterflow\Framework;

use PDO;
use PDOException;

class DatabaseWrapper
{

    private $db_handle;
    private $db_connection_settings;
    private $sql_queries;
    private $prepared_statement;

    /**
     * Method __construct
     * This method sets all the variables to null.
     *
     */
    public function __construct()
    {
        $this->db_handle = null;
        $this->db_connection_settings = null;
        $this->prepared_statement = null;
        $this->sql_queries = null;
    }

    public function __destruct(){}

    /**
     * Method setDBConnectionSettings
     * This method sets the database connection settings.
     *
     * @param $db_connection_settings 'Predefined settings from the user'
     * @return void
     *
     */
    public function setDBConnectionSettings($db_connection_settings)
    {
        $this->db_connection_settings = $db_connection_settings;
    }

    /**
     * Method setSqlQueries
     * This method sets the instance of SqlQueries in this variable.
     *
     * @param $sql_queries 'Instance of SqlQueries'
     * @return void
     *
     */
    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    /**
     * Method connectDatabase
     * This method allows the connection of the application to the database.
     *
     * @return string 'Return result of successful or unsuccessful connection'
     *
     */
    public function connectDatabase()
    {
        $databaseConnectionError = '';

        $db_settings = $this->db_connection_settings;
        $host_name = $db_settings['rdbms'] . ':host=' . $db_settings['host'];
        $port_number = ';port=3306';
        $user_database = ';dbname='. $db_settings['db_name'];
        $host_details = $host_name . $port_number . $user_database;
        $user_name = $db_settings['user'];
        $user_password = $db_settings['password'];
        $pdo_attributes = $db_settings['options'];

        try {
            $pdo_handle = new PDO($host_details, $user_name, $user_password, $pdo_attributes);
            $this->db_handle = $pdo_handle;
        } catch(PDOException $exception) {
            trigger_error('error connecting to the database...');
            $databaseConnectionError = 'error connecting to the database...';
        }

        return $databaseConnectionError;
    }

    /**
     * Method safeQuery
     * This method takes a query string as parameter and runs it on the database.
     *
     * @param $query_string 'The query string'
     * @param $params 'Optional, if there are query parameters set and the query string requires to fill placeholders'
     * @return bool 'Return true if query is successful, false otherwise'
     *
     */
    public function safeQuery($query_string, $params = null): bool
    {
        $this->errors['db_error'] = false;
        $query_parameters = $params;

        try {
            $this->prepared_statement = $this->db_handle->prepare($query_string);
            $execute_result = $this->prepared_statement->execute($query_parameters);
            $this->errors['execute-OK'] = $execute_result;
        } catch (PDOException $exception_object) {
            $error_message  = 'PDO Exception caught. ';
            $error_message .= 'Error with the database access.' . "\n";
            $error_message .= 'SQL query: ' . $query_string . "\n";
            $error_message .= 'Error: ' . var_dump($this->prepared_statement->errorInfo(), true) . "\n";
            $this->errors['db_error'] = true;
            $this->errors['sql_error'] = $error_message;
        }
        return $this->errors['db_error'];
    }

    /**
     * Method countRows
     * This method returns the number of rows from the query that has been run.
     *
     * @return mixed 'Return number of rows or false otherwise'
     *
     */
    public function countRows()
    {
        return $this->prepared_statement->rowCount();
    }

    /**
     * Method safeFetchRow
     * This method returns the row result of the query that has been run.
     *
     * @return mixed 'Return result or false otherwise'
     *
     */
    public function safeFetchRow()
    {
        return $this->prepared_statement->fetch(PDO::FETCH_NUM);
    }

    /**
     * Method safeFetchArray
     * This method returns the array result of the query that has been run.
     *
     * @return mixed 'Return array or false otherwise'
     *
     */
    public function safeFetchArray()
    {
        $row = $this->prepared_statement->fetch(PDO::FETCH_ASSOC);
        $this->prepared_statement->closeCursor();
        return $row;
    }
}
