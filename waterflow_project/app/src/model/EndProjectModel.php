<?php
/**
 * EndProjectModel.php
 *
 * This class uses a series of method to end a project and retrieve relevant information from that project.
 *
 */
namespace Waterflow\Model;

class EndProjectModel
{
    private $db_wrapper;
    private $db_connection_settings;
    private $sql_queries;

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
     * Method completeAllTasks
     * This method runs a query to set all tasks for a project to complete.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return void
     *
     */
    public function completeAllTasks($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $query_string = $sql_queries->completeAllTasks($_SESSION['project_id']);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);
    }

    /**
     * Method setProjectFinished
     * This method runs a query to set the project to finished.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return void
     *
     */
    public function setProjectFinished($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $query_string = $sql_queries->setProjectFinished($_SESSION['project_id']);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);
    }

    /**
     * Method retrieveProjectDetails
     * This method runs a query to obtain the details of a project.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return mixed 'Return details of the project, false otherwise'
     *
     */
    public function retrieveProjectDetails($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $query_string = $sql_queries->retrieveProjectDetails($_SESSION['project_id']);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        return $this->db_wrapper->safeFetchArray();
    }

    /**
     * Method findProjectClient
     * This method runs a query to find the project client.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $project_client 'Username of the project_client'
     * @return mixed 'Return the project client, false otherwise'
     *
     */
    public function findProjectClient($db_connection_settings, $sql_queries, $db_wrapper, $project_client)
    {
        $query_string = $sql_queries->findProjectClient($project_client);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        return $this->db_wrapper->safeFetchRow();
    }

    /**
     * Method retrieveAllTasks
     * This method runs a query to retrieve all the tasks related to a project.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return array 'Return an array of tasks'
     *
     */
    public function retrieveAllTasks($db_connection_settings, $sql_queries, $db_wrapper): array
    {
        $query_string = $sql_queries->retrieveTasks($_SESSION['project_id']);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $task_array = [];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($task_array, $row);
        }

        return $task_array;
    }

    /**
     * Method cleanParameters
     * This method validates the project name, which is give by the user to name the report text file.
     *
     * @param $validator 'Validator instance'
     * @param $input_parameters 'Inputted data from user'
     * @return mixed 'Return the project name within an array'
     *
     */
    public function cleanParameters($validator, $input_parameters)
    {
        return $validator->sanitiseString($input_parameters['project_name']);
    }
}