<?php

require_once __DIR__ . ('/vendor/autoload.php');

use Syllabus\Container\Container;
use Syllabus\Controller\WordController;
use Syllabus\Core\Application;
use Syllabus\Database\Database;
use Syllabus\Handler\WordHandler;
use Syllabus\Http\Router;
use Syllabus\IO\FileReaderInterface;
use Syllabus\IO\Reader;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");

$container = new Container();

if (!$_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $application = $container->get(Application::class);
    $application->run();
} else {
    $router = $container->get(Router::class);
    $wordController = $container->get(WordController::class);
    $syllabus = $container->get(Syllabus::class);
    $reader = $container->get(Reader::class);
    $wordHandler = $container->get(WordHandler::class);

    $router->get(
        '/',
        function () {
            echo "hi";
        }
    );

    $router->get("/word", function () use ($wordController) {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            print_r($uri);
            $wordController->getAll();
        }
    );

    $router->delete('/word', function () use ($wordHandler, $wordController) {
        $entityBody = file_get_contents('php://input');
        $data = json_decode($entityBody, true);
        $word = $data['wordString'];

        header("Content-type:application/json");
        if (!$wordHandler->isWordInDatabase($word)) {
            echo json_encode(
                [
                    'message' => "word $word doesn't exist"
                ]
            );
            header("HTTP/1.0 404 Not Found");
            return;
        }

        $wordController->delete($word);
    });

    $router->post('/word', function () use ($wordController, $wordHandler, $syllabus, $reader) {
        $entityBody = file_get_contents('php://input');
        $data = json_decode($entityBody, true);

        $word = new Word($data['wordString']);

        if ($wordHandler->isWordInDatabase($word)) {
            echo json_encode(
              [
                  'message' => "word is already in database"
              ]
            );
            return;
        }
        $patterns = $reader->readFromFileToCollection(FileReaderInterface::DEFAULT_PATTERN_LINK);
        $syllabifiedWord = $syllabus->hyphenate($word, $patterns);
        $foundPatters = $syllabus->findPatternsInWord($word, $patterns);
        $word->setSyllabifiedWord($syllabifiedWord);

        $wordController->post($word, $foundPatters);
    });

//    $router->put('/word', function () use ($wordController, $wordHandler, $syllabus){
//        $entityBody = file_get_contents('php://input');
//
//        $data = json_decode($entityBody, true);
//        $currentWord = $data['currentWordString'];
//
//        if (!$wordHandler->isWordInDatabase($data['currentWordString'])) {
//            header("Content-type:application/json");
//            if (!$wordHandler->isWordInDatabase($currentWord)) {
//                echo json_encode(
//                    [
//                        'message' => "word $currentWord doesn't exist"
//                    ]
//                );
//                header("HTTP/1.0 404 Not Found");
//                return;
//            }
//        } else {
//            $syllabus->hyphenate();
//        }
//    });


    $router->run();
}
