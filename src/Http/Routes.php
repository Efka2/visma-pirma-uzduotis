<?php

namespace Syllabus\Http;

use Syllabus\Controller\WordController;
use Syllabus\Database\Database;
use Syllabus\Handler\WordHandler;
use Syllabus\Model\Word;

class Routes
{

    
    public static function route(Router $router)
    {
        $router->get('/');

        $router->get(
            "/word",
            function () use ($wordController, $twig) {
                $wordController->getAll();
            }
        );

        $router->delete(
            '/word',
            function () use ($wordHandler, $wordController) {
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
            }
        );

        $router->post(
            '/word',
            function () use ($wordController, $wordHandler, $syllabus, $reader) {
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
            }
        );
    }
}
