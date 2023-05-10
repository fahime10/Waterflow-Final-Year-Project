<?php
/**
 * TaskOverviewView.php
 *
 * This class uses a series of methods and the view created depends upon user request.
 *
 */
namespace Waterflow\View;

class TaskOverviewView
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * Method createTaskOverviewView
     * This method uses a Twig template to produce the view.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $task_array 'Arrays of tasks'
     * @param $check 'Boolean value to check if tasks are completed or not'
     * @return void 'The HTML view'
     *
     */
    public function createTaskOverviewView($view, $response, $task_array, $check)
    {
        $html_output = "
            <table id='tasks'>
                <tr>
                    <th>Task Description</th>
                    <th>Task Assigned To</th>
                    <th>Due Date</th>
                    <th>Completed</th>
                </tr>
                ";

        for($i = 0; $i < sizeof($task_array); $i++) {
            $row = $task_array[$i];
            $html_output .= "<tr class='unselected'>
                    <td id='task_id' style='display: none;'>$row[0]</td>
                    <td id='project_id_task' style='display: none;'>$row[1]</td><input type='text' name='project_id_task' value='$row[1]' style='display: none;'>
                    <td id='description'>$row[2]</td>
                    <td id='assigned_to'>$row[3]</td>
                    <td id='due_date'>$row[4]</td>";

            //checked boxes
            if ($row[5] == 1) {
                if ($_SESSION['clearance'] > 2) {
                    if ($check) {
                        $html_output .= "<td id='completed'><input type='hidden' value='0' name='${row[0]}'><input type='checkbox' name='${row[0]}' value='1' checked disabled></td>";
                    } else {
                        $html_output .= "<td id='completed'><input type='hidden' value='0' name='${row[0]}'><input type='checkbox' name='${row[0]}' value='1' checked></td>";
                    }
                } else {
                    $html_output .= "<td id='completed'><input type='hidden' value='0' name='${row[0]}'><input type='checkbox' name='${row[0]}' value='1' checked disabled></td>";
                }

            } else {
                //unchecked boxes
                if ($_SESSION['clearance'] > 2) {
                    $html_output .= "<td id='completed'><input type='hidden' value='0' name='${row[0]}'><input type='checkbox' name='${row[0]}' value='1'></td>";
                } else {
                    $html_output .= "<td id='completed'><input type='hidden' value='0' name='${row[0]}'><input type='checkbox' name='${row[0]}' value='1' disabled></td>";
                }
            }
        }

        $html_output .= "</tr>
                </table>";

        $view->render(
            $response,
            'task_overview.html.twig',
            [
                'username' => $_SESSION['first_name'],
                'title' => APP_NAME,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO,
                'js_path' => TASKS_JS,
                'action_logout' => FIRST_PAGE,
                'action_start_task' => 'add_new_task',
                'action_reload' => 'task_overview',
                'clearance' => $_SESSION['clearance'],
                'save_progress' => 'save_progress',
                'end_project' => 'end_project',
                'method' => 'post',
                'method_2' => 'get',
                'tasks' => $html_output
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
     * Method createAddTaskView
     * This method uses a Twig template to produce the form that is used to add a task.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $users 'Usernames of employees'
     * @param $teams 'Teams'
     * @return void 'The HTML view'
     *
     */
    public function createAddTaskView($view, $response, $users, $teams)
    {
        $html_output = "<label for='option'>Assign task to:
                            <select id='user' name='task_assigned'>
                                <optgroup label='---Users---'>";

        foreach ($users as $user) {
            $html_output .= "
                            <option value='$user' name='$user'>$user</option>";
        }
        $html_output .= "</optgroup>";

        $html_output .= "<optgroup label='---Teams---'>";
        foreach ($teams as $team) {
            $html_output .= "<option value='$team' name='$team'>$team</option>";
        }

        $html_output .= "</optgroup>
                        </select>
                    </label>";

        $view->render(
            $response,
            'add_new_task.html.twig',
            [
                'title' => APP_NAME,
                'action' => 'task_overview',
                'method' => 'post',
                'options' => $html_output,
                'js_path' => ADD_TASKS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }

    /**
     * Method createEditTaskView
     * This method uses a Twig template to produce the form that is used to edit a task.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @param $users 'Usernames of employees'
     * @param $teams 'Teams'
     * @return void 'The HTML view'
     *
     */
    public function createEditTaskView($view, $response, $users, $teams)
    {
        $html_output = "<label for='option'>Assign task to:
                            <select id='user' name='task_assigned'>
                                <optgroup label='---Users---'>";

        foreach ($users as $user) {
            $html_output .= "
                            <option value='$user' name='$user'>$user</option>";
        }
        $html_output .= "</optgroup>";

        $html_output .= "<optgroup label='---Teams---'>";
        foreach ($teams as $team) {
            $html_output .= "<option value='$team' name='$team'>$team</option>";
        }

        $html_output .= "</optgroup>
                        </select>
                    </label>";

        $view->render(
            $response,
            'edit_task.html.twig',
            [
                'title' => APP_NAME,
                'action' => 'task_overview',
                'method' => 'post',
                'options' => $html_output,
                'js_path' => EDIT_TASKS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }

    /**
     * Method createDeleteView
     * This method uses a Twig template to produce the form that is used to delete a task.
     *
     * @param $view 'view instance'
     * @param $response 'Response object'
     * @return void 'The HTML view'
     *
     */
    public function createDeleteTaskView($view, $response)
    {
        $view->render(
            $response,
            'delete_task.html.twig',
            [
                'title' => APP_NAME,
                'action' => 'task_overview',
                'method' => 'post',
                'js_path' => DELETE_TASKS_JS,
                'css_styles' => STYLES_PATH,
                'logo' => LOGO
            ]
        );
    }
}