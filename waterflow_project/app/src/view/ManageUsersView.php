<?php
/**
 * ManageUsersView.php
 *
 * This class uses a series of methods and the view created depends upon user request.
 *
 */
namespace Waterflow\View;

class ManageUsersView
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * Method createManageUsersView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $user_array 'Array of users'
     * @param $team_array 'Array of teams'
     * @return void 'The HTML view'
     *
     */
    public function createManageUsersView($view, $response, $user_array, $team_array)
    {
        $html_output = "<p>Please select a user to edit or delete</p><br>";
        $html_output .= "<table id='users'>
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Username</th>
                                <th>Clearance</th>
                            </tr>";

        foreach($user_array as $user) {
            $html_output .= "<tr class='unselected'>
                            <td id='user_id' style='display: none;'>$user[0]</td>
                            <td id='first_name'>$user[1]</td>
                            <td id='last_name'>$user[2]</td>
                            <td id='username'>$user[3]</td>
                            <td id='clearance'>$user[5]</td>
                        </tr>";
        }

        $html_output .= "</table>";

        $html_output_2 = "<p id='not_selected_team' style='display: none; color: red;'>Please select a team to delete</p><br>";
        $html_output_2 .= "<table id='teams'>
                                <tr>
                                    <th>Username</th>
                                    <th>Team name</th>
                                </tr>";

        foreach ($team_array as $team) {
            $html_output_2 .= "<tr class='unselected'>
                                <td id='username'>$team[0]</td>
                                <td id='team_name'>$team[1]</td>
                               </tr>";
        }

        $html_output_2 .= "</table>";

        $view->render(
            $response,
            'manage_users.html.twig',
            [
                'username' => $_SESSION['first_name'],
                'title' => APP_NAME,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO,
                'js_path' => MANAGE_USERS_JS,
                'action_logout' => FIRST_PAGE,
                'action_start' => 'start_project',
                'action_add_user' => 'add_new_user',
                'clearance' => $_SESSION['clearance'],
                'first_page' => FIRST_PAGE,
                'method' => 'post',
                'users' => $html_output,
                'teams' => $html_output_2
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

    /**
     * Method createAddUserView
     * This method uses a Twig template to produce the form that is used to add a user.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createAddUserView($view, $response)
    {
        $view->render(
            $response,
            'add_new_user.html.twig',
            [
                'title' => APP_NAME,
                'action' => 'manage_users',
                'method' => 'post',
                'js_path' => ADD_USERS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }

    /**
     * Method createEditUserView
     * This method uses a Twig template to produce the form that is used to edit a user.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createEditUserView($view, $response)
    {
        $view->render(
            $response,
            'edit_user.html.twig',
            [
                'title' => APP_NAME,
                'action' => 'manage_users',
                'method' => 'post',
                'js_path' => EDIT_USERS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }

    /**
     * Method createDeleteUserView
     * This method uses a Twig template to produce the form that is used to delete a user.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createDeleteUserView($view, $response)
    {
        $view->render(
            $response,
            'delete_user.html.twig',
            [
                'title' => APP_NAME,
                'action' => 'manage_users',
                'method' => 'post',
                'js_path' => DELETE_USERS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }
}