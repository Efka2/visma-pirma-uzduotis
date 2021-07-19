<?php

require_once('autoload.php');
require_once('src/Syllabus/Core/Router.php');

use Syllabus\Controller\WordController;
use Syllabus\Core\Application;
use Syllabus\Core\Logger;
use Syllabus\Core\Router;

if (!$_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $application = new Application(new Logger());
    $application->run();
} else {

    $router = new Router();
    $router->get('/word', WordController::class . "::getAll");
    $router->delete('/word', function ($id){
        if($id['id']){
            $wordController = new WordController(new Syllabus\Database\Database());
            $wordController->delete($id['id']);
        }
    });
    $router->run();

}
