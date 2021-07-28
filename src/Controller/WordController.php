<?php

namespace Syllabus\Controller;

use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollection;
use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;
use Twig\Environment;

use function PHPUnit\Framework\throwException;

class WordController
{
    private PatternWordHandler $patternWordHandler;
    private WordHandler $wordHandler;
    private Syllabus $syllabus;
    private Environment $twig;

    public function __construct(
        Syllabus $syllabus,
        PatternWordHandler $patternWordHandler,
        WordHandler $wordHandler,
        Environment $twig
    ) {
        $this->patternWordHandler = $patternWordHandler;
        $this->wordHandler = $wordHandler;
        $this->syllabus = $syllabus;
        $this->twig = $twig;
    }

    public function index()
    {
        $data = $this->patternWordHandler->getWordsAndPatters();

        $template = $this->twig->load('word/index.twig.html');

        echo $template->render(
            [
                'name' => 'Evaldas',
                'data' => $data
            ]
        );
    }

    public function create()
    {
        $template = $this->twig->load('/word/create.twig.html');
        echo $template->render();
    }

    public function store(string $wordString, CollectionInterface $patternCollection)
    {
        $word = new Word($wordString);
        $syllabifiedWord = $this->syllabus->hyphenate($word, $patternCollection);
        $word->setSyllabifiedWord($syllabifiedWord);
        $foundPatterns = $this->syllabus->findPatternsInWord($word, $patternCollection);

        $this->wordHandler->insert($word);
        $this->patternWordHandler->insert($word, $foundPatterns);

        header("Content-Type: application/json");
        header("HTTP/1.0 201 Created");

//        echo json_encode(
//            [
//                'message' => 'word successfully created',
//                'word' => $word->getWordString(),
//                'syllabifiedWord' => $word->getSyllabifiedWord()
//            ]
//        );
    }

    public function edit(int $id)
    {
        $template = $this->twig->load('/word/edit.twig.html');
        $word = $this->wordHandler->getById($id);

        if (empty($word)) {
            header("HTTP/1.1 404 Not Found");
            echo "Word not found";
            die();
        }

        echo $template->render(
            [
                'id' => $id,
                'word' => $word
            ]
        );
    }

    public function show(int $id)
    {
        $word = $this->wordHandler->getById($id);
        $template = $this->twig->load('word/show.twig.html');
        $patterns = $this->patternWordHandler->getPatterns($id);

        echo $template->render(
            [
                'id' => $id,
                'word' => $word,
                'patterns' => $patterns->getAll()
            ]
        );
    }

    public function update(string $currentWord, string $replaceWord, CollectionInterface $patternCollection)
    {
        $currentWordObject = $this->wordHandler->getByString($currentWord);
        $replaceWordObject = new Word($replaceWord);
        $syllabifiedWord = $this->syllabus->hyphenate($replaceWordObject, $patternCollection);
        $replaceWordObject->setSyllabifiedWord($syllabifiedWord);
        $foundPatters = $this->syllabus->findPatternsInWord($currentWordObject, $patternCollection);

        $this->wordHandler->update($currentWordObject, $replaceWordObject);
        //todo add update method to patternWordHandler
        $this->patternWordHandler->insert($replaceWordObject, $foundPatters);

        $this->index();
    }

    public function delete(int $id)
    {
        $wordModel = $this->wordHandler->getById($id);
        $deleteStatus = $this->wordHandler->deleteById($id);

        echo "successfully deleted";
//        if ($deleteStatus == 0) {
//            $data = [
//                'message' => "word successfully deleted",
//                'wordString' => $word,
//                'syllabifiedWord' => $wordModel->getSyllabifiedWord()
//            ];
//        } else {
//            $data = [
//                'message' => "word $word was not found"
//            ];
//            header("HTTP/1.0 404 Not Found");
//        }
//
//        header("Content-Type: application/json");
//        $json = json_encode($data);
//        echo $json;
    }
}
