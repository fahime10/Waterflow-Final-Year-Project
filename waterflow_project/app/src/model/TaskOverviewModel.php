<?php
/**
 * TaskOverviewModel.php
 *
 * This class uses a series of methods to connect to the database and add, edit and delete tasks.
 * It also deals with validating parameters.
 *
 */
namespace Waterflow\Model;

class TaskOverviewModel
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
     * Method cleanTaskParameters
     * This method validates and sanitises user inputted data.
     *
     * @param $validator 'Validator instance'
     * @param $input_parameters 'Array of parameters to be sanitised'
     * @return array 'Return an array with validated data'
     *
     */
    public function cleanTaskParameters($validator, $input_parameters): array
    {
        $count_parameters = count($input_parameters);
        $cleaned_parameters = [];

        $tainted_description = $input_parameters['task_description'];
        $tainted_assigned = $input_parameters['task_assigned'];

        switch ($count_parameters) {
            case 4:
                $cleaned_parameters['project_id'] = $input_parameters['project_id_task'];
                $cleaned_parameters['task_description'] = $validator->sanitiseString($tainted_description);
                $cleaned_parameters['task_assigned'] = $validator->sanitiseString($tainted_assigned);
                $cleaned_parameters['task_due_date'] = $input_parameters['task_due_date'];
                break;

            case 5:
                $cleaned_parameters['task_id'] = $input_parameters['task_id'];

                $cleaned_parameters['project_id'] = $input_parameters['project_id_task'];
                $cleaned_parameters['task_description'] = $validator->sanitiseString($tainted_description);
                $cleaned_parameters['task_assigned'] = $validator->sanitiseString($tainted_assigned);
                $cleaned_parameters['task_due_date'] = $input_parameters['task_due_date'];
                break;

            default:
                break;
        }

        return $cleaned_parameters;
    }

    /**
     * Method retrieveAllTasks
     * This method runs a query for retrieving all tasks from the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $project_id 'Project id'
     * @return array 'Return an array of tasks'
     *
     */
    public function retrieveAllTasks($db_connection_settings, $sql_queries, $db_wrapper, $project_id): array
    {
        $query_string = $sql_queries->retrieveTasks($project_id);

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
     * Method retrieveAllUsers
     * This method runs a query to retrieve all users stored in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return array 'Return an array of users'
     *
     */
    public function retrieveAllUsers($db_connection_settings, $sql_queries, $db_wrapper): array
    {
        $query_string = $sql_queries->retrieveAllUsers3();

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $user_array = [];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($user_array, $row[3]);
        }

        return $user_array;
    }

    /**
     * Method retrieveAllTeams
     * This method runs a query for retrieving all teams stored in the database.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return array 'Return an array of teams'
     *
     */
    public function retrieveAllTeams($db_connection_settings, $sql_queries, $db_wrapper): array
    {
        $query_string = $sql_queries->retrieveAllTeams();

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        $team_array = [];
        for ($i = 0; $i < $this->db_wrapper->countRows(); $i++) {
            $row = $this->db_wrapper->safeFetchRow();
            array_push($team_array, $row[0]);
        }

        return $team_array;
    }

    /**
     * Method checkFinished
     * This method runs a query to check if a project has been finished.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $project_id 'Project id'
     * @return bool 'Return true if project is set to 'finished', false otherwise'
     *
     */
    public function checkFinished($db_connection_settings, $sql_queries, $db_wrapper, $project_id): bool
    {
        $check = false;
        $id = (int)$project_id;
        $query_string = $sql_queries->checkFinished($id);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);

        if ($this->db_wrapper->countRows() > 0) {
            $check = true;
        }

        return $check;
    }

    /**
     * Method storeNewTask
     * This method runs a query to add a task.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $input_parameters 'Array of parameters'
     * @return void
     *
     */
    public function storeNewTask($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters)
    {
        $id = $input_parameters['project_id'];
        $project_id = (int) $id;
        $query_string = $sql_queries->storeTask($project_id);

        $query_parameters = [
            ':task_description' => $input_parameters['task_description'],
            ':task_assigned' => $input_parameters['task_assigned'],
            ':task_due_date' => $input_parameters['task_due_date']
        ];

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, $query_parameters);
    }

    /**
     * Method updateTask
     * This method runs a query for editing a task.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $cleaned_parameters 'Array of parameters'
     * @return void
     *
     */
    public function updateTask($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters)
    {
        $id = $cleaned_parameters['task_id'];
        $task_id = (int) $id;

        $query_string = $sql_queries->editTask($cleaned_parameters, $task_id);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);
    }

    /**
     * Method deleteTask
     * This method runs a query for deleting a task.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $input_parameters 'Array of parameters'
     * @return void
     *
     */
    public function deleteTask($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters)
    {
        $id = $input_parameters['task_id'];
        $task_id = (int) $id;

        $query_string = $sql_queries->deleteTask($task_id);

        $this->setDatabaseWrapper($db_wrapper);
        $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
        $this->db_wrapper->connectDatabase();
        $this->db_wrapper->safeQuery($query_string, null);
    }

    /**
     * Method saveProgress
     * This method runs a query for updating the 'completed' attribute in the database for tasks.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @param $input_parameters 'Array of parameters'
     * @return void
     *
     */
    public function saveProgress($db_connection_settings, $sql_queries, $db_wrapper, $input_parameters)
    {
        $array_keys = array_keys($input_parameters);

        for($i = 1; $i < count($input_parameters); $i++) {
            $query_string = $sql_queries->saveProgress($array_keys[$i], $input_parameters[$array_keys[$i]]);
            $this->setDatabaseWrapper($db_wrapper);
            $this->db_wrapper->setDBConnectionSettings($db_connection_settings);
            $this->db_wrapper->connectDatabase();
            $this->db_wrapper->safeQuery($query_string, null);
        }
    }

    /**
     * Method lastId
     * This method runs a query for retrieving the last id in the project table.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return mixed 'Return last id from project table, false otherwise'
     *
     */
    public function lastId($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $last_id_query = $sql_queries->getLastId('project', 'project_id');

        $db_wrapper->setDBConnectionSettings($db_connection_settings);
        $db_wrapper->connectDatabase();
        $db_wrapper->safeQuery($last_id_query, null);
        $last_id = $db_wrapper->safeFetchRow();

        return $last_id;
    }

    /**
     * Method lastIdTask
     * This method runs a query to retrieve the last id from the task table.
     *
     * @param $db_connection_settings 'Database settings from the user'
     * @param $sql_queries 'SqlQueries instance'
     * @param $db_wrapper 'DatabaseWrapper instance'
     * @return mixed 'Return the last id from task table, false otherwise'
     *
     */
    public function lastIdTask($db_connection_settings, $sql_queries, $db_wrapper)
    {
        $last_id_query = $sql_queries->getLastId('task', 'task_id');

        $db_wrapper->setDBConnectionSettings($db_connection_settings);
        $db_wrapper->connectDatabase();
        $db_wrapper->safeQuery($last_id_query, null);
        $last_id = $db_wrapper->safeFetchRow();

        return $last_id;
    }

}