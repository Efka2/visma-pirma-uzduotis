<?php

namespace Syllabus\Controller;

use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollection;
use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;

class WordController
{
    private PatternWordHandler $patternWordHandler;
    private WordHandler $wordHandler;
    private Syllabus $syllabus;

    public function __construct(Syllabus $syllabus, PatternWordHandler $patternWordHandler, WordHandler $wordHandler)
    {
        $this->patternWordHandler = $patternWordHandler;
        $this->wordHandler = $wordHandler;
        $this->syllabus = $syllabus;
    }

    public function getAll()
    {
        $patterns = $this->patternWordHandler->getWordsAndPatters();
        return json_encode($patterns);
    }

    public function post(Word $word, CollectionInterface $patternCollection)
    {
        $this->wordHandler->insert($word);
        $this->patternWordHandler->insert($word, $patternCollection);

        header("Content-Type: application/json");
        header("HTTP/1.0 201 Created");

        echo json_encode(
            [
                'message' => 'word successfully created',
                'word' => $word->getWordString(),
                'syllabifiedWord' => $word->getSyllabifiedWord()
            ]
        );
    }

    public function put(string $currentWord, array $params)
    {
        $word = $this->wordHandler->get($currentWord);
        $this->wordHandler->update($word, $params);
    }

    public function delete(string $word)
    {
        $wordModel = $this->wordHandler->get($word);
        $deleteStatus = $this->wordHandler->delete($word);

        if ($deleteStatus == 0) {
            $data = [
                'message' => "word successfully deleted",
                'wordString' => $word,
                'syllabifiedWord' => $wordModel->getSyllabifiedWord()
            ];
        } else {
            $data = [
                'message' => "word $word was not found"
            ];
            header("HTTP/1.0 404 Not Found");
        }

        header("Content-Type: application/json");
        $json = json_encode($data);
        echo $json;
    }
}
