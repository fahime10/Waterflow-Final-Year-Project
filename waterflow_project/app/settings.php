<?php
/**
 * settings.php
 *
 * This script defines pathways to CSS files, the JavaScript files required for DOM manipulation,
 * parameters that will be used throughout the whole application, and more settings on Twig templates and
 * connecting to the database.
 *
 */
$app_url = dirname($_SERVER['SCRIPT_NAME']);
$css_login = $app_url . '/css/login.css';
$css_styles = $app_url . '/css/styles.css';
$icon = $app_url . '/media/waterfall-logo.jpg';

$manage_users_js = $app_url . '/scripts/manage_users.js';
$add_users_js = $app_url . '/scripts/add_users.js';
$edit_users_js = $app_url . '/scripts/edit_users.js';
$delete_users_js = $app_url . '/scripts/delete_users.js';

$projects_js = $app_url . '/scripts/projects.js';
$start_projects_js = $app_url . '/scripts/start_projects.js';
$edit_projects_js = $app_url . '/scripts/edit_projects.js';
$delete_projects_js = $app_url . '/scripts/delete_projects.js';

$tasks_js = $app_url . '/scripts/tasks.js';
$add_tasks_js = $app_url . '/scripts/add_tasks.js';
$edit_tasks_js = $app_url . '/scripts/edit_tasks.js';
$delete_tasks_js = $app_url . '/scripts/delete_tasks.js';

$create_teams_js = $app_url . '/scripts/create_teams.js';

$folder_path = __DIR__. '/finished_projects/';

$company_email_username = "Please input company email";
$company_email_password = "Please input email password";

define('FIRST_PAGE', $app_url);
define('LOGIN_PATH', $css_login);
define('STYLES_PATH', $css_styles);
define('LOGO', $icon);
define('MANAGE_USERS_JS', $manage_users_js);
define('ADD_USERS_JS', $add_users_js);
define('EDIT_USERS_JS', $edit_users_js);
define('DELETE_USERS_JS', $delete_users_js);
define('PROJECTS_JS', $projects_js);
define('START_PROJECTS_JS', $start_projects_js);
define('EDIT_PROJECTS_JS', $edit_projects_js);
define('DELETE_PROJECTS_JS', $delete_projects_js);
define('TASKS_JS', $tasks_js);
define('ADD_TASKS_JS', $add_tasks_js);
define('EDIT_TASKS_JS', $edit_tasks_js);
define('DELETE_TASKS_JS', $delete_tasks_js);
define('CREATE_TEAMS_JS', $create_teams_js);
define('FOLDER_PATH', $folder_path);
define('EMAIL_USERNAME', $company_email_username);
define('EMAIL_PASSWORD', $company_email_password);

const APP_NAME = "Waterflow Manager";
const BCRYPT_COST = 12;
const BCRYPT_ALGO = PASSWORD_DEFAULT;

$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'addContentHeader' => false,
        'mode' => 'development',
        'debug' => false,
        'view' => [
            'template_path' => __DIR__ . '/templates/',
            'twig' => [
                'cache' => false,
                'auto_reload' => true,
            ]
        ],
        'pdo_settings' => [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'waterflow_db',
            'port' => '3306',
            'user' => 'Please input a db username',
            'password' => 'Please input db password',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ],
    ],
];

return $settings;