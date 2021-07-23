<?php

namespace Syllabus\Controller;

use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;
use Syllabus\Model\Word;

class WordController
{
    private PatternWordHandler $patternWordHandler;
    private WordHandler $wordHandler;

    public function __construct(PatternWordHandler $patternWordHandler, WordHandler $wordHandler)
    {
        $this->patternWordHandler = $patternWordHandler;
        $this->wordHandler = $wordHandler;
    }

    public function getAll()
    {
        $patterns = $this->patternWordHandler->getWordsAndPatters();

        header("Content-Type: application/json");
        $json = json_encode($patterns);
        echo($json);
    }

    public function post(Word $word)
    {
        $this->wordHandler->insert($word);

        header("Content-Type: application/json");
        header("HTTP/1.0 201 Created");
    }

    public function put(string $currentWord, array $params)
    {
        $word = $this->wordHandler->get($currentWord);
        $this->wordHandler->update($word, $params);
    }

    public function delete(string $word)
    {
        $deleteStatus = $this->wordHandler->delete($word);

        if ($deleteStatus == 0) {
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
