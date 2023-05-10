<?php
/**
 * ResultChangeController.php
 *
 * This class uses createHtmlOutput to create an HTML output for the user to see the result of the changed password.
 * If username was incorrect, then the password is never changed for any username in the database.
 *
 */
namespace Waterflow\Controller;

class ResultChangeController
{
    /**
     * Method createHtmlOutput
     * This method creates an HTML output using an instance of view and ResultChangeView.
     * The model class, ResultChangeModel, uses instances of DatabaseWrapper,SqlQueries and BcryptWrapper to process
     * the change of the password.
     *
     * @param $app 'The SLIM application defined in settings.php'
     * @param $request 'The request from the user sent as parameter'
     * @param $response 'The response to be handled when view is processed'
     * @return void 'Return the web page'
     *
     */
    public function createHtmlOutput($app, $request, $response)
    {
        $input_parameters = $request->getParsedBody();

        $view = $app->getContainer()->get('view');

        $db_wrapper = $app->getContainer()->get('databaseWrapper');

        $result_change_model = $app->getContainer()->get('resultChangeModel');
        $result_change_view = $app->getContainer()->get('resultChangeView');

        $db_conf = $app->getContainer()->get('settings');
        $db_connection_settings = $db_conf['pdo_settings'];
        $sql_queries = $app->getContainer()->get('sqlQueries');

        $validator = $app->getContainer()->get('validator');
        $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');

        $cleaned_parameters = $result_change_model->cleanParameters($validator, $input_parameters);

        $result = $result_change_model->changeUserPassword($db_connection_settings, $sql_queries, $db_wrapper, $cleaned_parameters, $bcrypt_wrapper);

        $result_change_view->createResultChangeView($view, $response, $result);
    }
}