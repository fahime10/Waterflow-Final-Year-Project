<?php
/**
 * ProjectOverviewModel.php
 *
 * This class uses a series of methods to validate user login and deal with add, edit and delete of projects.
 *
 */
namespace Waterflow\Model;

class ProjectOverviewModel
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
     * This method validates and sanitises the inputs from the user before applying those strings into the query.
     *
     * @param $validator 'Validator instance'
     * @param $input_parameters 'Inputted data from user'
     * @return array 'Return validated array'
     *
     */
    public function cleanParameters($validator, $input_parameters): array
    {
        $cleaned_parameters = [];

        $tainted_username = $input_parameters['username'];

        $cleaned_parameters['sanitised_username'] = $validator->sanitiseString($tainted_username);
        $cleaned_parameters['sanitised_password'] = $input_parameters['password'];

        return $cleaned_parameters;
    }

    /**
     * Method cleanProjectParameters
     * This method validates and sanitises the inputs from the user before running a query.
     *
     * @param $validator 'Validator instance'
     * @param $input_parameters 'Inputted data from user'
     * @return array 'Return an array of validated data'
     *
     */
    public function cleanProjectParameters($validator, $input_parameters): array
    {
        $count_parameters = count($input_parameters);
        $cleaned_parameters = [];

        switch($count_parameters) {
            case 3:
                $tainted_project = $input_parameters['project_name'];
                $tainted_client = $input_parameters['stakeholder'];

                $cleaned_parameters['project_name'] = $validator->sanitiseString($tainted_project);
                $cleaned_parameters['project_manager'] = $_SESSION['user'];
                $cleaned_parameters['project_client'] = $validator->sanitiseString($tainted_client);
                $cleaned_parameters['project_due_date'] = $input_parameters['due_date'];
            break;

            case 4:
                $tainted_project = $input_parameters['project_name'];
                $tainted_client = $input_parameters['project_client'];

                $cleaned_parameters['project_id'] = $input_parameters['project_id'];
                $cleaned_parameters['project_name'] = $validator->sanitiseString($tainted_project);
                $cleaned_parameters['project_client'] = $validator->sanitiseString($tainted_client);
                $cleaned_parameters['project_due_date'] = $input_parameters['project_due_date'];
                break;

            default:
                break;
        }

        return $cleaned_parameters;
    }

    /**
     * Method hash_password
     * This method hashes a password.
     *
     * @param $bcrypt_wrapper 'BcryptWrapper instance'
     * @param $password 'Plain text password'
     * @return string 'Return a hashed password'
     *
     */
    function hash_password($bcrypt_wrapper, $password): string
    {
        return $bcrypt_wrapper->createHashPassword($password);
    }

    /**
     * Method findUser
     * This method runs a query to find and authenticate a user.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $cleaned_parameters 'Array of parameters'
     * @param $bcrypt_wrapper 'BcryptWrapper instance'
     * @return array 'Return an array with user's information, else empty array'
     *
     */
    public function findUser($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters, $bcrypt_wrapper)
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
        $user = [];

        if($find_row) {
            $username = $find_row[3];
            $hashed_password = $find_row[4];
            $check_password = $bcrypt_wrapper->authenticatePassword($cleaned_parameters['sanitised_password'], $hashed_password);


            if ($username == $cleaned_parameters['sanitised_username'] && $check_password) {
                $user['first_name'] = $find_row[1];
                $user['last_name'] = $find_row[2];
                $user['username'] = $find_row[3];
                $user['clearance'] = $find_row[5];
            }
        }

        return $user;
    }

    /**
     * Method retrieveAllProjects
     * This method retrieves all projects stored in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return array 'Return an array of all projects'
     *
     */
    public function retrieveAllProjects($db_connection_settings, $sql_queries, $db_wrapper) {
        $query_string = $sql_queries->retrieveProjects();

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $project_array = [];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($project_array, $row);
        }

        return $project_array;
    }

    /**
     * Method retrieveStakeholders
     * This method runs a query to retrieve every stakeholder stored in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return array 'Return an array with every stakeholder'
     *
     */
    public function retrieveStakeholders($db_connection_settings, $sql_queries, $db_wrapper) {
        $query_string = $sql_queries->retrieveAllStakeholders();

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $stakeholder_array = [];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($stakeholder_array, $row[0]);
        }

        return $stakeholder_array;
    }

    /**
     * Method retrieveRelevantProjects
     * This method runs a query to retrieve only relevant projects, which are relevant to stakeholders.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $username 'Stakholder username'
     * @return array 'Return an array connected to the stakeholder'
     *
     */
    public function retrieveRelevantProjects($db_connection_settings, $sql_queries, $db_wrapper, $username): array
    {
        $query_string = $sql_queries->retrieveStakeholderView($username);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $project_array = [];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($project_array, $row);
        }

        return $project_array;
    }

    /**
     * Method storeNewProject
     * This method runs a query to store a new project in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $cleaned_parameters 'Array of parameters'
     * @param $user 'Manager who is starting the project'
     * @return void
     *
     */
    public function storeNewProject($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters, $user)
    {
        $query_string = $sql_queries->storeProject();

        $query_parameters = [
            ':project_name' => $cleaned_parameters['project_name'],
            ':project_manager' => $user,
            ':project_client' => $cleaned_parameters['project_client'],
            ':project_due_date' => $cleaned_parameters['project_due_date']
        ];

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, $query_parameters);
    }

    /**
     * Method updateProject
     * This method runs a query to update a project.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $input_parameters 'Array of parameters'
     * @return void
     *
     */
    public function updateProject($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters)
    {
        $id = $input_parameters['project_id'];
        $project_id = (int) $id;

        $query_string = $sql_queries->editSelectedProject($input_parameters, $project_id);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);
    }

    /**
     * Method deleteProject
     * This method runs a query to delete a project.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $input_parameters 'Array of parameters'
     * @return void
     *
     */
    public function deleteProject($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters)
    {
        $id = $input_parameters['project_id'];
        $project_id = (int) $id;

        $query_string = $sql_queries->deleteSelectedProject($project_id);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);
    }

    /**
     * Method lastId
     * This method runs a query to retrieve the last id in the project table.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return mixed 'Return last id, false otherwise'
     *
     */
    public function lastId($db_connection_settings, $sql_queries, $db_wrapper)
    {

        $last_id_query = $sql_queries->getLastId('project', 'project_id');

        $db_wrapper->setDBConnectionSettings($db_connection_settings);
        $db_wrapper->connectDatabase();
        $db_wrapper->safeQuery($last_id_query, null);

        return $db_wrapper->safeFetchRow();
    }
}