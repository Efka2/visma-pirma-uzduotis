<?php


namespace Syllabus\Controller;


use Syllabus\Database\Database;
use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;

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

    public function post()
    {
        echo "xey post";
    }

    public function patch()
    {

    }

    public function delete($id)
    {
        $wordHandler = new WordHandler(new Database());
        $wordHandler->delete($id);

        $data = ['Word successfully deleted.'];

        header("Content-Type: application/json");
        $json = json_encode($data);
        echo $json;
    }
}