<?php


namespace Syllabus\Controller;


use Syllabus\Database\Database;
use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;
use Syllabus\Model\Word;

class WordController
{
    public function getAll()
    {
        $patternHandler = new PatternWordHandler(new Database());

        $patterns = $patternHandler->getWordsAndPatters();

        header("Content-Type: application/json");
        $json =  json_encode($patterns);
        echo ($json);
    }

    public function post(Word $word)
    {
        $wordHandler = new WordHandler(new Database());
        $wordHandler->insert($word);

        header("Content-Type: application/json");
        header("HTTP/1.0 201 Created");
    }

    public function put(string $currentWord, array $params)
    {
        $wordHandler = new WordHandler(new Database());
        $word = $wordHandler->get($currentWord);
        $wordHandler->update($word, $params);
    }

    public function delete(string $word)
    {
        $wordHandler = new WordHandler(new Database());
        $deleteStatus = $wordHandler->delete($word);

        if($deleteStatus == 0){
            $data = 'Word successfully deleted.';
        } else {
            $data = 'This word was not found';
            header("HTTP/1.0 404 Not Found");
        }


        header("Content-Type: application/json");
        $json = json_encode($data);
        echo $json;
    }
}