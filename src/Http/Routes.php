<?php

namespace Syllabus\Http;

use Syllabus\Controller\WordController;
use Syllabus\Database\Database;
use Syllabus\Handler\WordHandler;
use Syllabus\Model\Word;

$router = new Router();

$router->get("/word", function (){
    echo "hi";
});

$router->delete('/word', function () {
    $entityBody = file_get_contents('php://input');
    //todo add if
    $data = json_decode($entityBody, true);

    $wordController = new WordController();
    $wordController->delete($data['wordString']);
});

$router->post('/word', function () {
    $entityBody = file_get_contents('php://input');
    //todo add if
    $data = json_decode($entityBody, true);


    $word = new Word();
    $word->setWordString($data['wordString']);
    $word->setSyllabifiedWord($data['syllabifiedWord']);

    $wordController = new WordController();
    $wordController->post($word);
});

$router->put('/word', function () {
    $entityBody = file_get_contents('php://input');

    $data = json_decode($entityBody, true);
    $wordHandler = new WordHandler(new Database());
    $wordController = new WordController();
    $currentWord = $data['currentWordString'];


    if ($wordHandler->isWordInDatabase($data['currentWordString'])) {
        $wordController->put($currentWord, $data);
    }
});


$router->run();
