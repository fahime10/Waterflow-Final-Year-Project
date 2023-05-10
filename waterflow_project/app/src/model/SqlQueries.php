<?php
/**
 * SqlQueries.php
 *
 * This class uses a series of method to predefine a SQL queries for coding convenience.
 *
 */
namespace Waterflow\Model;

class SqlQueries
{
    /**
     * Method retrieveUser
     * SQL query for retrieving a user.
     *
     * @return string 'SQL query for retrieving user'
     *
     */
    public static function retrieveUser() {
        $query_string = "SELECT * FROM users ";
        $query_string .= "WHERE user_username = :username ";
        return $query_string;
    }

    /**
     * Method changePassword
     * SQL query for changing password.
     *
     * @return string 'SQL query for changing a user's password'
     */
    public static function changePassword() {
        $query_string = "UPDATE users ";
        $query_string .= "SET user_password = :password ";
        $query_string .= "WHERE  user_username = :username";
        return $query_string;
    }

    /**
     * Method retrieveAllUsers
     * SQL query for retrieving all users from the database.
     *
     * @return string 'SQL query for retrieving all users'
     *
     */
    public static function retrieveAllUsers() {
        return "SELECT * FROM users";
    }

    /**
     * Method retrieveProjects
     * SQL query for retrieving all projects from the database.
     *
     * @return string 'SQL query for retrieving all projects'
     *
     */
    public static function retrieveProjects() {
        return "SELECT * FROM project";
    }

    /**
     * Method retrieveStakeholderView
     * SQL query for retriving all projects associated to a stakeholder.
     *
     * @param $username 'Stakeholder username'
     * @return string 'SQL query for retrieving projects with a related stakeholder'
     *
     */
    public static function retrieveStakeholderView($username) {
        return "SELECT * FROM project WHERE project_client = '$username'";
    }

    /**
     * Method retrieveAllStakholders
     * SQL query for retrieving all stakeholders from the database.
     *
     * @return string 'SQL query for retriving all stakeholders'
     *
     */
    public static function retrieveAllStakeholders() {
        return "SELECT user_username FROM users WHERE clearance_id = 2";
    }

    /**
     * Method storeProject
     * SQL query for storing a project in the database.
     *
     * @return string 'SQL query for adding a project'
     *
     */
    public static function storeProject() {
        $query_string = "INSERT INTO project (project_name, project_manager, project_client, project_due_date, project_finished)";
        $query_string .= "VALUES (:project_name, :project_manager, :project_client, :project_due_date, false)";
        return $query_string;
    }

    /**
     * Method editSelectedProject
     * SQL query for editing a project.
     *
     * @param $cleaned_parameters 'Array of parameters'
     * @param $project_id 'Project id to identify which project to edit'
     * @return string 'SQL query for editing a project'
     *
     */
    public static function editSelectedProject($cleaned_parameters, $project_id) {
        $query_string = "UPDATE project ";
        $query_string .= "SET project_name = '${cleaned_parameters['project_name']}', ";
        $query_string .= "project_client = '${cleaned_parameters['project_client']}', ";
        $query_string .= "project_due_date = '${cleaned_parameters['project_due_date']}' ";
        $query_string .= "WHERE project_id = $project_id";
        return $query_string;
    }

    /**
     * Method deleteSelectedProject
     * SQL query for deleting a project.
     *
     * @param $project_id 'Project id to identify which project to delete'
     * @return string 'SQL query for deleting a project'
     *
     */
    public static function deleteSelectedProject($project_id) {
        return "DELETE FROM project WHERE project_id = $project_id";
    }

    /**
     * Method retrieveTasks
     * SQL for retrieving all tasks stored in the database.
     *
     * @param $project_id 'Project id to identify which tasks'
     * @return string 'SQL query for retrieving tasks'
     *
     */
    public static function retrieveTasks($project_id) {
        return "SELECT * FROM task WHERE project_id = $project_id";
    }

    /**
     * Method storeTask
     * SQL query for adding a new task.
     *
     * @param $project_id 'Project id to identify to which project the task is assigned to'
     * @return string 'SQL query for adding a task'
     *
     */
    public static function storeTask($project_id) {
        $query_string = "INSERT into task (project_id, task_description, task_assigned, task_due_date, task_completed) ";
        $query_string .= "VALUES ($project_id, :task_description, :task_assigned, :task_due_date, false)";
        return $query_string;
    }

    /**
     * Method editTask
     * SQL query for editing a task.
     *
     * @param $cleaned_parameters 'Array of parameters'
     * @param $task_id 'Specific task id'
     * @return string 'SQL query for editing a task'
     *
     */
    public static function editTask($cleaned_parameters, $task_id) {
        $query_string = "UPDATE task ";
        $query_string .= "SET task_description = '${cleaned_parameters['task_description']}', ";
        $query_string .= "task_assigned = '${cleaned_parameters['task_assigned']}', ";
        $query_string .= "task_due_date = '${cleaned_parameters['task_due_date']}' ";
        $query_string .= "WHERE task_id = $task_id";

        return $query_string;
    }

    /**
     * Method deleteTask
     * SQL query for deleting a task.
     *
     * @param $task_id 'Specific task id'
     * @return string 'SQL query for deleting a task'
     */
    public static function deleteTask($task_id) {
        return "DELETE FROM task WHERE task_id = $task_id";
    }

    /**
     * Method saveProgress
     * SQL query for saving the progress of a task.
     *
     * @param $task_id 'Specific task id'
     * @param $completed 'True or false'
     * @return string 'SQL query to edit the 'completed' attribute'
     */
    public static function saveProgress($task_id, $completed) {
        $query_string = "UPDATE task ";
        $query_string .= "SET task_completed = $completed ";
        $query_string .= "WHERE task_id = $task_id";

        return $query_string;
    }

    /**
     * Method storeUser
     * SQL query for adding a new user.
     *
     * @return string 'SQl query for adding a user'
     *
     */
    public static function storeUser() {
        $query_string = "INSERT INTO users (user_first_name, user_last_name, user_username, user_password, clearance_id) ";
        $query_string .= "VALUES (:first_name, :last_name, :username, :password, :clearance)";
        return $query_string;
    }

    /**
     * Method editSelectedUser
     * SQL query for editing a user.
     *
     * @param $input_parameters 'Array of parameters'
     * @param $user_id 'User id'
     * @return string 'SQL query for editing a user'
     *
     */
    public static function editSelectedUser($input_parameters, $user_id) {
        $query_string = "UPDATE users ";
        $query_string .= "SET user_first_name = '${input_parameters['first_name']}', ";
        $query_string .= "user_last_name = '${input_parameters['last_name']}', ";
        $query_string .= "user_username = '${input_parameters['username']}', ";
        $query_string .= "clearance_id = ${input_parameters['clearance']} ";
        $query_string .= "WHERE user_id = $user_id";
        return $query_string;
    }

    /**
     * Method deleteSelectedUser
     * SQL query for deleting a user.
     *
     * @param $user_id 'User id'
     * @return string 'SQL query for deleting a user'
     *
     */
    public static function deleteSelectedUser($user_id) {
        return "DELETE FROM users WHERE user_id = $user_id";
    }

    /**
     * Method retrieveALlUsers3
     * SQL query to retrieve every user with clearance 3.
     *
     * @return string 'SQL to retrieve users with clearance 3'
     *
     */
    public static function retrieveAllUsers3() {
        return "SELECT * from users WHERE clearance_id = 3";
    }

    /**
     * Method makeTeam
     * SQL query for adding teammates to a team.
     *
     * @param $username 'User's username'
     * @param $team_name 'Team's name'
     * @return string 'SQL query to add user to a team'
     *
     */
    public static function makeTeam($username, $team_name) {
        $query_string = "INSERT INTO team (user_username, team_name) ";
        $query_string .= "VALUES (\"$username\", \"$team_name\")";
        return $query_string;
    }

    /**
     * Method retrieveAllTeams
     * SQL query for retrieving all teams from the database.
     *
     * @return string 'SQL query for retrieving all teams'
     *
     */
    public static function retrieveAllTeams() {
        return "SELECT DISTINCT team_name FROM team";
    }

    /**
     * Method getAllTeams
     * SQL query to retrieve every team and their members.
     *
     * @return string 'SQL query to retrieve teams and members'
     *
     */
    public static function getAllTeams() {
        return "SELECT * FROM team";
    }

    /**
     * Method completeAllTasks
     * SQL query for setting all tasks to 'completed'.
     *
     * @param $project_id 'Project id'
     * @return string 'SQL query for setting all tasks to 'completed''
     */
    public static function completeAllTasks($project_id) {
        $query_string = "UPDATE task ";
        $query_string .= "SET task_completed = true ";
        $query_string .= "WHERE project_id = $project_id";

        return $query_string;
    }

    /**
     * Method setProjectFinished
     * SQL query for setting the project to 'finished'.
     *
     * @param $project_id 'Project id'
     * @return string 'SQL query for setting the project to 'finished''
     *
     */
    public static function setProjectFinished($project_id) {
        $query_string = "UPDATE project ";
        $query_string .= "SET  project_finished = true ";
        $query_string .= "WHERE project_id = $project_id";

        return $query_string;
    }

    /**
     * Method checkFinished
     * SQL for checking if the project has been set to 'finished'.
     *
     * @param $id 'Project id'
     * @return string 'SQL query for checking project status'
     *
     */
    public static function checkFinished($id) {
        $query_string = "SELECT * FROM project ";
        $query_string .= "WHERE project_finished = true AND project_id = $id";

        return $query_string;
    }

    /**
     * Method retrieveProjectDetails
     * SQL query for retrieving details of a project given project id.
     *
     * @param $project_id 'Project id'
     * @return string 'SQL query to retrieve details of a project'
     *
     */
    public static function retrieveProjectDetails($project_id) {
        return "SELECT * FROM project WHERE project_id = $project_id";
    }

    /**
     * Method findProjectClient
     * SQL query to find the project client.
     *
     * @param $project_client 'Stakeholder username'
     * @return string 'SQL to find project client'
     *
     */
    public static function findProjectClient($project_client) {
        return "SELECT user_first_name, user_last_name FROM users WHERE user_username = '$project_client'";
    }

    /**
     * Method getLastId
     * SQL for finding the last id of a table.
     *
     * @param $table_name 'Name of the table'
     * @param $id_name 'Name of the id'
     * @return string 'SQL query for finding the last id'
     *
     */
    public static function getLastId($table_name, $id_name) {
        return "SELECT max($id_name) FROM $table_name";
    }
}