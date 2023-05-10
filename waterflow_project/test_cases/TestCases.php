<?php

namespace Waterflow\Framework;

use PDO;
use PHPUnit\Framework\TestCase;
use Waterflow\Model\ManageUsersModel;
use Waterflow\Model\ProjectOverviewModel;
use Waterflow\Model\SqlQueries;
use Waterflow\Model\TaskOverviewModel;

class TestCases extends TestCase
{
    /**
     * Test name testTrueAssertsToTrue
     * Test function to check that PHPUnit testings works as intended by asserting true on a variable that is set
     * to true.
     *
     * @return void
     *
     */
    public function testTrueAssertsToTrue()
    {
        $condition = true;
        $this->assertTrue($condition);
    }

    /**
     * Test name testConnectToDatabase
     * Test function to test whether the function can set a connection into the database.
     *
     * @return void
     *
     */
    public function testConnectToDatabase() {
        $db_wrapper = new DatabaseWrapper();
        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $db_wrapper->setDBConnectionSettings($db_connection_settings);
        $result = $db_wrapper->connectDatabase();

        $this->assertSame('', $result);
    }

    /**
     * Test name testSuccessfulLogin
     * Test function to test whether the function can login in to the database by using an existing user.
     *
     * @return void
     *
     */
    public function testSuccessfulLogin()
    {
        $whitelisted_user = [
            'sanitised_username' => 'jams',
            'sanitised_password' => 'password'
        ];

        $bcrypt_wrapper = new BcryptWrapper();
        $model = new ProjectOverviewModel();
        $db_wrapper = new DatabaseWrapper();
        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $user = $model->findUser($db_connection_settings, $sql_queries, $db_wrapper, $whitelisted_user, $bcrypt_wrapper);

        $this->assertSame($user['username'], "jams");
    }

    /**
     * Test name testUnsuccessfulLogin
     * Test function to test whether the database can recognise that the user used the wrong password, and therefore
     * no access to the application is allowed.
     *
     * @return void
     *
     */
    public function testUnsuccessfulLogin() {
        $whitelisted_user = [
            'sanitised_username' => 'jams',
            'sanitised_password' => 'pass'
        ];

        $bcrypt_wrapper = new BcryptWrapper();
        $model = new ProjectOverviewModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $user = $model->findUser($db_connection_settings, $sql_queries, $db_wrapper, $whitelisted_user, $bcrypt_wrapper);

        $this->assertSame($user, []);
    }

    /**
     * Test name testStartProject
     * Test function to test whether the function can create a new project from scratch using predefined values.
     *
     * @return void
     *
     */
    public function testStartProject() {
        $model = new ProjectOverviewModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $parameters = [
            'project_name' => 'Testing Development',
            'project_client' => 'test_client',
            'project_due_date' => '2023-05-02'
        ];

        $model->storeNewProject($db_connection_settings, $sql_queries, $db_wrapper, $parameters, 'test_manager');

        $query_string_2 = "SELECT * FROM project WHERE project_name = 'Testing Development'";
        $db_wrapper->safeQuery($query_string_2);

        $project = $db_wrapper->safeFetchRow();

        $this->assertSame($project[1], "Testing Development");
    }

    /**
     * Test name testAddTask
     * Test function to test whether the function can add a new task into the database.
     *
     * @return void
     *
     */
    public function testAddTask() {
        $model = new TaskOverviewModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $last_id = $model->lastId($db_connection_settings, $sql_queries, $db_wrapper);

        $parameters = [
            'project_id' => $last_id[0],
            'task_description' => 'task',
            'task_assigned' => 'manager',
            'task_due_date' => '2023-05-02'
        ];

        $model->storeNewTask($db_connection_settings, $sql_queries, $db_wrapper, $parameters);

        $query_string_2 = "SELECT * FROM task WHERE task_description = 'task'";
        $db_wrapper->safeQuery($query_string_2);

        $task = $db_wrapper->safeFetchRow();

        $this->assertSame($task[2], "task");
    }

    /**
     * Test name testEditTask
     * Test function to test whether the function can edit the newly created task.
     *
     * @return void
     *
     */
    public function testEditTask() {
        $model = new TaskOverviewModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $last_id_project = $model->lastId($db_connection_settings, $sql_queries, $db_wrapper);

        $last_id_task = $model->lastIdTask($db_connection_settings, $sql_queries, $db_wrapper);

        $parameters = [
            'project_id' => (int)$last_id_project[0],
            'task_id' => $last_id_task[0],
            'task_description' => 'newTask',
            'task_assigned' => 'manager',
            'task_due_date' => '2023-05-02'
        ];

        $model->updateTask($db_connection_settings, $sql_queries, $db_wrapper, $parameters);

        $query_string_2 = "SELECT * FROM task WHERE task_description = 'newTask'";
        $db_wrapper->safeQuery($query_string_2);

        $task = $db_wrapper->safeFetchRow();

        $this->assertSame($task[2], "newTask");
    }

    /**
     * Test name testDeleteTask
     * Test function to test whether the function can delete the edited task.
     *
     * @return void
     *
     */
    public function testDeleteTask() {
        $model = new TaskOverviewModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $last_id_task = $model->lastIdTask($db_connection_settings, $sql_queries, $db_wrapper);

        $parameters = [
            'task_id' => $last_id_task[0]
        ];

        $model->deleteTask($db_connection_settings, $sql_queries, $db_wrapper, $parameters);

        $query_string_2 = "SELECT * FROM task WHERE task_description = 'newTask'";
        $db_wrapper->safeQuery($query_string_2);

        $task = $db_wrapper->safeFetchRow();

        $this->assertSame($task, false);
    }

    /**
     * Test name testEditProject
     * Test function to test whether the function can edit the newly created project.
     *
     * @return void
     *
     */
    public function testEditProject() {
        $model = new ProjectOverviewModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $last_id = $model->lastId($db_connection_settings, $sql_queries, $db_wrapper);

        $parameters = [
            'project_id' => $last_id[0],
            'project_name' => 'TestingDevelopment',
            'project_client' => 'test_client',
            'project_due_date' => '2023-05-02'
        ];

        $model->updateProject($db_connection_settings, $sql_queries, $db_wrapper, $parameters);

        $query_string_2 = "SELECT * FROM project WHERE project_name = 'TestingDevelopment'";
        $db_wrapper->safeQuery($query_string_2);

        $project = $db_wrapper->safeFetchRow();

        $this->assertSame($project[1], "TestingDevelopment");
    }

    /**
     * Test name testDeleteProject
     * Test function to test whether the function can delete the edited project.
     *
     * @return void
     *
     */
    public function testDeleteProject() {
        $model = new ProjectOverviewModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $last_id = $model->lastId($db_connection_settings, $sql_queries, $db_wrapper);

        $parameters = [
            'project_id' => $last_id[0],
        ];

        $model->deleteProject($db_connection_settings, $sql_queries, $db_wrapper, $parameters);

        $query_string_2 = "SELECT * FROM project WHERE project_name = 'TestingDevelopment'";
        $db_wrapper->safeQuery($query_string_2);

        $project = $db_wrapper->safeFetchRow();

        $this->assertSame($project, false);
    }

    /**
     * Test name testAddUser
     * Test function to test whether the function can add a new user into the database.
     *
     * @return void
     *
     */
    public function testAddUser() {
        $model = new ManageUsersModel();
        $db_wrapper = new DatabaseWrapper();
        $bcrypt_wrapper = new BcryptWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $parameters = [
          'first_name' => 'First',
          'last_name' => 'Last',
          'username' => 'username',
          'password' => 'password',
          'clearance' => '1'
        ];

        $model->testStoreNewUser($db_connection_settings, $sql_queries, $db_wrapper, $bcrypt_wrapper, $parameters);

        $query_string_2 = "SELECT * FROM users WHERE user_username = 'username'";
        $db_wrapper->safeQuery($query_string_2);

        $user = $db_wrapper->safeFetchRow();

        $this->assertSame($user[3], 'username');
    }

    /**
     * Test name testEditUser
     * Test function to test whether the function can edit the newly created user.
     *
     * @return void
     *
     */
    public function testEditUser() {
        $model = new ManageUsersModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $last_id = $model->lastId($db_connection_settings, $sql_queries, $db_wrapper);

        $parameters = [
            'user_id' => $last_id[0],
            'first_name' => 'First',
            'last_name' => 'Last',
            'username' => 'new_user',
            'password' => 'password',
            'clearance' => '1'
        ];

        $model->updateUser($db_connection_settings, $sql_queries, $db_wrapper, $parameters);

        $query_string_2 = "SELECT * FROM users WHERE user_username = 'new_user'";
        $db_wrapper->safeQuery($query_string_2);

        $user = $db_wrapper->safeFetchRow();

        $this->assertSame($user[3], 'new_user');
    }

    /**
     * Test name testDeleleUser
     * Test function to test whether the function can delete the edited user.
     *
     * @return void
     *
     */
    public function testDeleteUser() {
        $model = new ManageUsersModel();
        $db_wrapper = new DatabaseWrapper();

        $db_connection_settings = [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'super_manager',
            'password' => 'top_manager',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ];

        $sql_queries = new SqlQueries();

        $last_id = $model->lastId($db_connection_settings, $sql_queries, $db_wrapper);

        $parameters = [
            'user_id' => $last_id[0]
        ];

        $model->deleteUser($db_connection_settings, $sql_queries, $db_wrapper, $parameters);

        $query_string_2 = "SELECT * FROM users WHERE user_username = 'new_user'";
        $db_wrapper->safeQuery($query_string_2);

        $user = $db_wrapper->safeFetchRow();

        $this->assertSame($user, false);
    }
}
