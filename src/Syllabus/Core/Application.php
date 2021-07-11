<?php
namespace Syllabus\Core;

use Syllabus\IO\Output;
use Syllabus\IO\Reader;
use Syllabus\Service\Syllabus;
use SplFileObject;

require_once ('src/Syllabus/IO/Reader.php');
require_once ('src/Syllabus/Service/Syllabus.php');
require_once ('src/Syllabus/Core/Application.php');

class Application{

    //readeris grazins patternCollection
    // modelis - pattern
    // result model
    public function run()
    {
        $filePath = "https://gist.githubusercontent.com/cosmologicon/1e7291714094d71a0e25678316141586/raw/006f7e9093dc7ad72b12ff9f1da649822e56d39d/tex-hyphenation-patterns.txt";
        $fileReader = new SplFileObject($filePath);
        $reader = new Reader();
        $patternArray = $reader->readFromFile($fileReader);

        $syllabus = new Syllabus('mistranslate');

        $finalWord = $syllabus->syllabify($patternArray);
        echo $finalWord;
    }
}