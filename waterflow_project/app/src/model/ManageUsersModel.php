<?php
/**
 * ManageUsersModel.php
 *
 * This class uses a series of methods to connect to the database and add, edit, delete users.
 * It also deals with adding new teams.
 *
 */
namespace Waterflow\Model;

class ManageUsersModel
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
     * Method getAllUsers
     * This method runs a query to retrieve all users stored in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return array 'Return an array of users'
     *
     */
    public function getAllUsers($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $query_string = $sql_queries->retrieveAllUsers();

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $user_array =[];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($user_array, $row);
        }

        return $user_array;
    }

    /**
     * Method getAllTeams
     * This method runs a query to retrieve all teams stored in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return array 'Return an array of teams'
     *
     */
    public function getAllTeams($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $query_string = $sql_queries->getAllTeams();

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $team_array =[];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($team_array, $row);
        }

        return $team_array;
    }

    /**
     * Method storeNewUser
     * This method runs a query to store details of a new user in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $bcrypt_wrapper 'BcryptWrapper instance'
     * @param $input_parameters 'User inputted data'
     * @return void
     *
     */
    public function storeNewUser($db_connection_settings, $sql_queries, $db_wrapper, $bcrypt_wrapper, $input_parameters)
    {
        $query_string = $sql_queries->storeUser();

        $hashed_password = $bcrypt_wrapper->createHashPassword($input_parameters['password']);

        $query_parameters = [
            ':first_name' => $input_parameters['first_name'],
            ':last_name' => $input_parameters['last_name'],
            ':username' => $input_parameters['username'],
            ':password' => $hashed_password,
            ':clearance' => $input_parameters['clearance']
        ];

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, $query_parameters);
    }

    /**
     * Method testStoreNewUser
     * This method runs a query to store details of a new user in the database. However, this method is only used
     * for a PHPUnit test case to bypass the issue of "Undefined BCRYPT ALGO".
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $bcrypt_wrapper 'BcryptWrapper instance'
     * @param $input_parameters 'User inputted data'
     * @return void
     *
     */
    public function testStoreNewUser($db_connection_settings, $sql_queries, $db_wrapper, $bcrypt_wrapper, $input_parameters)
    {
        $query_string = $sql_queries->storeUser();

        $hashed_password = $bcrypt_wrapper->hashPassword($input_parameters['password']);

        $query_parameters = [
            ':first_name' => $input_parameters['first_name'],
            ':last_name' => $input_parameters['last_name'],
            ':username' => $input_parameters['username'],
            ':password' => $hashed_password,
            ':clearance' => $input_parameters['clearance']
        ];

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, $query_parameters);
    }

    /**
     * Method updateUser
     * This method runs a query to edit details of user.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $input_parameters 'User inputted data'
     * @return void
     *
     */
    public function updateUser($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters)
    {
        $id = $input_parameters['user_id'];
        $user_id = (int) $id;

        $query_string = $sql_queries->editSelectedUser($input_parameters, $user_id);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);
    }

    /**
     * Method deleteUser
     * This method runs a query to delete a user.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $input_parameters 'User inputted data'
     * @return void
     *
     */
    public function deleteUser($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters)
    {
        $id = $input_parameters['user_id'];
        $user_id = (int) $id;

        $query_string = $sql_queries->deleteSelectedUser($user_id);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);
    }

    /**
     * Method lastId
     * This method runs a query to retrieve the last id from the users table in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return mixed 'Return last id, false otherwise'
     *
     */
    public function lastId($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $last_id_query = $sql_queries->getLastId('users', 'user_id');

        $db_wrapper->setDBConnectionSettings($db_connection_settings);
        $db_wrapper->connectDatabase();
        $db_wrapper->safeQuery($last_id_query, null);

        return $db_wrapper->safeFetchRow();
    }
}