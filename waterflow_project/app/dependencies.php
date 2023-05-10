<?php
/**
 * dependencies.php
 *
 * This script helps with to autoload the different routes and classes.
 * The classes require the correct namespace to work. The namespace must be defined in the composer.json.
 *
 */
use Slim\Views\Twig;

$container['view'] = function ($container) {
    $view = new Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig']
    );

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getURI()->getBasePath()),'/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['loginController'] = function () {
    return new Waterflow\Controller\LoginController();
};

$container['loginModel'] = function () {
    return new Waterflow\Model\LoginModel();
};

$container['loginView'] = function () {
    return new Waterflow\View\LoginView();
};

$container['sessionWrapper'] = function () {
    return new Waterflow\Framework\SessionWrapper();
};

$container['databaseWrapper'] = function () {
    return new Waterflow\Framework\DatabaseWrapper();
};

$container['sqlQueries'] = function () {
    return new Waterflow\Model\SqlQueries();
};

$container['bcryptWrapper'] = function () {
    return new Waterflow\Framework\BcryptWrapper();
};

$container['libSodiumWrapper'] = function () {
    return new Waterflow\Framework\LibSodiumWrapper();
};

$container['validator'] = function () {
    return new Waterflow\Model\Validator();
};

$container['projectOverviewController'] = function () {
    return new Waterflow\Controller\ProjectOverviewController();
};

$container['projectOverviewModel'] = function () {
    return new Waterflow\Model\ProjectOverviewModel();
};

$container['projectOverviewView'] = function () {
    return new Waterflow\View\ProjectOverviewView();
};

$container['taskOverviewController'] = function () {
    return new Waterflow\Controller\TaskOverviewController();
};

$container['taskOverviewModel'] = function () {
    return new Waterflow\Model\TaskOverviewModel();
};

$container['taskOverviewView'] = function () {
    return new Waterflow\View\TaskOverviewView();
};

$container['changePasswordController'] = function () {
    return new Waterflow\Controller\ChangePasswordController();
};

$container['changePasswordView'] = function () {
    return new Waterflow\View\ChangePasswordView();
};

$container['resultChangeController'] = function () {
    return new Waterflow\Controller\ResultChangeController();
};

$container['resultChangeModel'] = function () {
    return new Waterflow\Model\ResultChangeModel();
};

$container['resultChangeView'] = function () {
    return new Waterflow\View\ResultChangeView();
};

$container['manageUsersController'] = function () {
    return new Waterflow\Controller\ManageUsersController();
};

$container['manageUsersModel'] = function () {
    return new Waterflow\Model\ManageUsersModel();
};

$container['manageUsersView'] = function () {
    return new Waterflow\View\ManageUsersView();
};

$container['saveController'] = function () {
    return new Waterflow\Controller\SaveController();
};

$container['saveView'] = function () {
    return new Waterflow\View\SaveView();
};

$container['createTeamController'] = function () {
    return new Waterflow\Controller\CreateTeamController();
};

$container['createTeamModel'] = function () {
    return new Waterflow\Model\CreateTeamModel();
};

$container['createTeamView'] = function () {
    return new Waterflow\View\CreateTeamView();
};

$container['endProjectController'] = function () {
    return new Waterflow\Controller\EndProjectController();
};

$container['endProjectModel'] = function () {
    return new Waterflow\Model\EndProjectModel();
};

$container['endProjectView'] = function () {
    return new Waterflow\View\EndProjectView();
};

$container['viewReportsController'] = function () {
    return new Waterflow\Controller\ViewReportsController();
};

$container['viewReportsView'] = function () {
    return new Waterflow\View\ViewReportsView();
};

$container['displayReportController'] = function () {
    return new Waterflow\Controller\DisplayReportController();
};

$container['displayReportView'] = function () {
    return new Waterflow\View\DisplayReportView();
};

$container['sendEmailController'] = function () {
    return new Waterflow\Controller\SendEmailController();
};

$container['sendEmailView'] = function () {
    return new Waterflow\View\SendEmailView();
};


$container['resultEmailController'] = function () {
    return new Waterflow\Controller\ResultEmailController();
};


$container['resultEmailModel'] = function () {
    return new Waterflow\Model\ResultEmailModel();
};


$container['resultEmailView'] = function () {
    return new Waterflow\View\ResultEmailView();
};
