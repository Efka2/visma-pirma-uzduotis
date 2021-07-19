<?php

require_once('autoload.php');
require_once('src/Syllabus/Core/Router.php');

use Syllabus\Controller\WordController;
use Syllabus\Core\Application;
use Syllabus\Core\Logger;
use Syllabus\Core\Router;
use Syllabus\Model\Word;

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");


if (!$_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $application = new Application(new Logger());
    $application->run();
} else {

    $router = new Router();
    $router->get('/word', WordController::class . "::getAll");

    $router->delete('/word', function (array $params){
        if($params['word']){
            $wordController = new WordController();
            $wordController->delete($params['word']);
        }
    });

    $router->post('/word', function(){
        $entityBody = file_get_contents('php://input');
        //todo add if

        $data = json_decode($entityBody, true);

        $word = new Word();
        $word->setWordString($data['wordString']);
        $word->setSyllabifiedWord($data['syllabifiedWord']);

        $wordController = new WordController();
        $wordController->post($word);
    });


    $router->run();

}
