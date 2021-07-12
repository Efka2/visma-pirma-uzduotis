<?php

namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Core\PatternCollection;
use Syllabus\Model\Pattern;

class Reader implements FileReaderInterface
{
    public function readFromFileToCollection(SplFileObject $fileObject): PatternCollection
    {
        $data = new PatternCollection();

        while (!$fileObject->eof()) {
            $pattern = new Pattern(trim($fileObject->fgets()));
            $data->add($pattern);
        }

        $file = null;

        return $data;
    }

    public function readFromTerminal(): string
    {
        echo "Enter the word you want to syllabify: ";
        $line = trim(readline());

        while (strlen($line) === 0) {
            echo "Please enter a word: ";
            $line = trim(readline());
        }
        
        return $line;
    }
}
