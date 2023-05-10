<?php
/**
 * CreateTeamModel.php
 *
 * This class uses a series of methods to create a team.
 *
 */
namespace Waterflow\Model;

class CreateTeamModel
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
     *
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
     * Method retrieveAllUsers
     * This method runs a query to retrieve all users from the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return array 'Return array of users'
     *
     */
    public function retrieveAllUsers($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $query_string = $sql_queries->retrieveAllUsers3();

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $username_array = [];
        $user_full_name_array = [];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($username_array, $row[3]);
            array_push($user_full_name_array, $row[1] . " " . $row[2]);
        }

        return array_merge($user_full_name_array, $username_array);
    }

    /**
     * Method cleanParameters
     * This method uses an instance of validator to validate user input data.
     *
     * @param $validator 'Validator instance'
     * @param $input_parameters 'User input data'
     * @return array 'Return array with validated data'
     *
     */
    public function cleanParameters($validator, $input_parameters): array
    {
        $cleaned_parameters = [];

        foreach ($input_parameters as $value) {
            $clean_value = $validator->sanitiseString($value);
            array_push($cleaned_parameters, $clean_value);
        }

        return $cleaned_parameters;
    }

    /**
     * Method createTeam
     * This method runs a query to create a team.
     *
     * @param $db_connection_settings 'Database connection settings defined by user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $cleaned_parameters 'Parameters to use for the query'
     * @return mixed 'Return team name, false, otherwise'
     *
     */
    public function createTeam($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters)
    {
        $team_name = $cleaned_parameters[0];
        $newArray = array_slice($cleaned_parameters, 1);

        foreach ($newArray as $user) {
            var_dump($user);
            $query_string = $sql_queries->makeTeam($user, $team_name);

            $this->setDatabaseWrapper($db_wrapper);
            $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
            $this->db_wrapper->connectDatabase();
            $this->db_wrapper->safeQuery($query_string, null);
        }

        return $team_name;
    }
}