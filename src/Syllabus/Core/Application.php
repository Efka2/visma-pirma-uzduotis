<?php
namespace Syllabus\Core;

use Syllabus\IO\FileReaderInterface;
use Syllabus\IO\Output;
use Syllabus\IO\Reader;
use Syllabus\Model\Result;
use Syllabus\Service\Syllabus;
use SplFileObject;

class Application{

    public function run()
    {
        $fileReader = new SplFileObject(FileReaderInterface::DEFAULT_PATTERN_LINK);
        $reader = new Reader();
        $patternArray = $reader->readFromFileToCollection($fileReader);
        $word = $reader->readFromTerminal();

        $timeStart = new \DateTime();

        $syllabus = new Syllabus($word);
        $syllabifiedWord = $syllabus->syllabify($patternArray);

        $diff = $timeStart->diff(new \DateTime());
        $result = new Result($word,$syllabifiedWord,$syllabus->findPatternsInWord($patternArray),$diff);

        Output::printAnswerToTerminal($result);

    }
}