<?php
namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Core\Collection;
use Syllabus\Model\Pattern;

class Reader implements FileReaderInterface {

    public function readFromFileToCollection(SplFileObject $fileObject) : Collection
    {
        $data = new Collection();

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

        while(strlen($line) === 0){
            echo "Please enter a word: ";
            $line = trim(readline());
        }

        return $line;
    }
}
