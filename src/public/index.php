<?php
/*
 * PHP default script that will setup the app via the Phalcon Framework
 *
 * @author: Humberto Moreira <humberto.mn@gmail.com>
 */

use App\Constants\Services as AppServices;

// Version and Timezone
date_default_timezone_set('UTC');

// Setups up environment variable
$local_config_file = __DIR__ . "/../app/config/local.php";
$application_env = file_exists($local_config_file) ? 'development' : 'production';

/** @var \PhalconRest\Http\Response $response */
$response = null;

try {

    // Reads the configuration based on env
    $config = require __DIR__ . "/../app/bootstrap/config.php";

    // Includes loader
    require __DIR__ . "/../app/bootstrap/loader.php";

    // Setup all required services (DI)
    $di = require __DIR__ . "/../app/bootstrap/services.php";

    // Instantiates main application
    $app = new \Phalcon\Mvc\Micro($di);

    // Attaches the EventsManager to the main application in order to attach Middleware
    $eventsManager = $app->di->get(AppServices::EVENTS_MANAGER);
    $app->setEventsManager($eventsManager);

    // Attaches Middleware to EventsManager
    require __DIR__ . "/../app/bootstrap/middleware.php";

    // Mounts Collections
    require __DIR__ . "/../app/bootstrap/collections.php";

    // Other routes
    $app->get('/', function() use ($app) {

        /** @var Phalcon\Mvc\View\Simple $view */
        $view = $app->di->get(AppServices::VIEW);

        return $view->render('general/index');
    });

    // Starts application
    $app->handle();

    // Sets content
    $returnedValue = $app->getReturnedValue();

    if($returnedValue !== null){

        if(is_string($returnedValue)){

            $app->response->setContent($returnedValue);
        }
        else {

            $app->response->setJsonContent($returnedValue);
        }
    }

    $response = $app->response;

} catch (Exception $e) {

    $response = $di->get(AppServices::RESPONSE);
    $response->setErrorContent($e, $application_env == 'development');
}

// Sends response
if($response){

    $response->sendHeaders();
    $response->send();
}