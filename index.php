<?php

require_once __DIR__ . ('/vendor/autoload.php');

use Syllabus\Container\Container;
use Syllabus\Controller\WordController;
use Syllabus\Core\Application;
use Syllabus\Database\Database;
use Syllabus\Handler\WordHandler;
use Syllabus\Http\Router;
use Syllabus\Model\Word;

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

$container = new Container();

if (!$_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $application = $container->get(Application::class);
    $application->run();
} else {
    $router = new Router();
    $wordController = $container->get(WordController::class);

    $router->get(
        '/',
        function () {
            echo "hi";
        }
    );

    $router->get(
        "/word",
        function () use ($wordController) {
            $wordController->getAll();
        }
    );

//    $router->delete('/word', function () {
//        $entityBody = file_get_contents('php://input');
//        //todo add if
//        $data = json_decode($entityBody, true);
//
//        $wordController = new WordController();
//        $wordController->delete($data['wordString']);
//    });
//
//    $router->post('/word', function () {
//        $entityBody = file_get_contents('php://input');
//        //todo add if
//        $data = json_decode($entityBody, true);
//
//
//        $word = new Word();
//        $word->setWordString($data['wordString']);
//        $word->setSyllabifiedWord($data['syllabifiedWord']);
//
//        $wordController = new WordController();
//        $wordController->post($word);
//    });
//
//    $router->put('/word', function () {
//        $entityBody = file_get_contents('php://input');
//
//        $data = json_decode($entityBody, true);
//        $wordHandler = new WordHandler(new Database());
//        $wordController = new WordController();
//        $currentWord = $data['currentWordString'];
//
//
//        if ($wordHandler->isWordInDatabase($data['currentWordString'])) {
//            $wordController->put($currentWord, $data);
//        }
//    });


    $router->run();
}
