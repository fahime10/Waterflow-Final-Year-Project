<?php
/**
 * CreateTeamView.php
 *
 * This class uses createTeamView to provide the user with a form to create a team with its members.
 *
 */
namespace Waterflow\View;

class CreateTeamView
{
    public function __construct(){}
    public function __destruct(){}

    /**
     * Method createTeamView
     * This method uses a Twig template to produce the view.
     * It also requires an array of users.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $users 'Array with users'
     * @return void 'The HTML view'
     *
     */
    public function createTeamView($view, $response, $users)
    {
        $html_output = "<h2>List of users</h2>
                        <table id='users'>
                            <tr>
                                <th>User's full name</th>
                                <th>User's username</th>
                            </tr>
                            ";

        $users_full_name = array_splice($users, 0, count($users) / 2);
        $users_username = $users;

        for ($i = 0; $i < count($users_full_name); $i++) {
            $html_output .= " <tr>
                                <td>${users_full_name[$i]}</td>
                                <td>${users_username[$i]}</td>
                              </tr>";
        }

        $html_output .= "</table>";

        $view->render(
            $response,
            'create_team.html.twig',
            [
                'title' => APP_NAME,
                'table' => $html_output,
                'method' => 'post',
                'css_styles' => STYLES_PATH,
                'js_path' => CREATE_TEAMS_JS
            ]
        );
    }

    /**
     * Method createTeamViewResult
     * This method uses a Twig template to produce the view.
     * This method returns a page with the result of the added team into the database.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $team_name 'Team name from the previous page'
     * @param $users 'All users assigned to this team name'
     * @return void 'The HTML view'
     *
     */
    public function createTeamViewResult($view, $response, $team_name, $users)
    {
        $html_output = "<table>
                            <tr>
                                <th>User's username</th>
                            </tr>
                            ";

        for ($i = 1; $i < count($users); $i++) {
            $html_output .= " <tr>
                                <td>${users[$i]}</td>
                              </tr>";
        }

        $html_output .= "</table>";

        $view->render(
            $response,
            'confirm_team.html.twig',
            [
                'table' => $html_output,
                'team_name' => $team_name,
                'method' => 'post',
                'return' => 'project_overview',
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
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
}