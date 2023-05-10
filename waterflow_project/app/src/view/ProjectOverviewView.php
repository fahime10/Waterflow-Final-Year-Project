<?php
/**
 * ProjectOVerviewView.php
 *
 * This class uses a series of methods and the view created depends upon user request.
 *
 */
namespace Waterflow\View;

class ProjectOverviewView
{
    public function __construct(){}
    public function __destruct(){}

    /**
     * Method createProjectOverviewView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $user 'Username of the user'
     * @param $project_array 'Array of projects'
     * @return void 'The HTML view'
     *
     */
    public function createProjectOverviewView($view, $response, $user, $project_array)
    {
        if(!empty($user)) {
            $html_output = "
                        <table id='projects'>
                            <tr>
                                <th>Project</th>
                                <th>Project Manager</th>
                                <th>Stakeholder</th>
                                <th>Due Date</th>
                                <th>Finished</th>
                            </tr>
                    ";

            for($i = 0; $i < sizeof($project_array); $i++) {
                $row = $project_array[$i];

                if ($row[5] == 0) {
                    $finished = "No";
                } else {
                    $finished = "Yes";
                }

                $html_output .= "        <tr class='unselected'>
                                    <td id='project_id' style='display: none;'>$row[0]</td>
                                    <td id='project'>$row[1]</td>
                                    <td id='project_manager'>$row[2]</td>
                                    <td id='project_client'>$row[3]</td>
                                    <td id='due_date'>$row[4]</td>
                                    <td id='finished'>$finished</td>
                                    </tr>";
            }

            $html_output .= "</table>";

            $view->render(
                $response,
                'project_overview.html.twig',
                [
                    'username' => $_SESSION['first_name'],
                    'title' => APP_NAME,
                    'css_styles' => STYLES_PATH,
                    'logo' => LOGO,
                    'js_path' => PROJECTS_JS,
                    'action_logout' => FIRST_PAGE,
                    'action_teams' => 'create_team',
                    'action_start' => 'start_project',
                    'action_manage' => 'manage_users',
                    'action_reports' => 'view_reports',
                    'action_pass' => 'change_password',
                    'action_email' => 'send_email',
                    'method' => 'post',
                    'method_2' => 'get',
                    'projects' => $html_output,
                    'clearance' => $_SESSION['clearance']
                ]
            );
        } else {
            $view->render(
                $response,
                'error.html.twig',
                [
                    'message' => $user,
                    'title' => APP_NAME,
                    'first_page' => FIRST_PAGE,
                    'css_styles' => STYLES_PATH,
                    'logo' => LOGO
                ]
            );
        }
    }

    /**
     * Method createErrorView
     * This method creates an error page.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createViewError($view, $response)
    {
        $view->render(
            $response,
            'error_view.html.twig',
            [
                'title' => APP_NAME,
                'css_styles' => STYLES_PATH,
                'first_page' => FIRST_PAGE,
                'logo' => LOGO
            ]
        );
    }

    /**
     * Method createStartProjectView
     * This method uses a Twig template to produce the form that is used to start a new project.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $stakeholder_array 'Array of stakeholders'
     * @return void 'The HTML view'
     *
     */
    public function createStartProjectView($view, $response, $stakeholder_array)
    {
        $html_output = "<label for='option'>Project client: 
                            <select id='stakeholder' name='stakeholder'>";

        foreach ($stakeholder_array as $user) {
            $html_output .= "<option value='$user' name='$user'>$user</option>";
        }

        $html_output .= "</select>
                    </label>";

        $view->render(
            $response,
            'start_project.html.twig',
            [
                'action' => 'project_overview',
                'method' => 'post',
                'title' => APP_NAME,
                'options' => $html_output,
                'js_path' => START_PROJECTS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }

    /**
     * Method createEditProjectView
     * This method uses a Twig template to produce the form that is used to edit a project.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $stakeholder_array 'Array of stakeholders'
     * @return void 'The HTML view'
     *
     */
    public function createEditProjectView($view, $response, $stakeholder_array)
    {
        $html_output = "<label for='option'>Project client: 
                            <select id='project_client' name='project_client'>";

        foreach ($stakeholder_array as $user) {
            $html_output .= "<option name='$user'>$user</option>";
        }

        $html_output .= "</select>
                    </label>";

        $view->render(
            $response,
            'edit_project.html.twig',
            [
                'action' => 'project_overview',
                'method' => 'post',
                'title' => APP_NAME,
                'options' => $html_output,
                'js_path' => EDIT_PROJECTS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }

    /**
     * Method createDeleteProjectView
     * This method uses a Twig template to produce the form that is used to delete a project.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createDeleteProjectView($view, $response)
    {
        $view->render(
            $response,
            'delete_project.html.twig',
            [
                'action' => 'project_overview',
                'method' => 'post',
                'title' => APP_NAME,
                'js_path' => DELETE_PROJECTS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }
}