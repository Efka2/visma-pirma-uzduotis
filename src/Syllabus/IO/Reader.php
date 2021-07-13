<?php

namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Core\PatternCollection;
use Syllabus\Model\Pattern;

class Reader implements FileReaderInterface
{
    public const WORD = 1;
    public const SENTENCE = 2;
    
    public function readFromFileToCollection(SplFileObject $fileObject
    ): PatternCollection {
        $data = new PatternCollection();
        
        while (!$fileObject->eof()) {
            $pattern = new Pattern(trim($fileObject->fgets()));
            $data->add($pattern);
        }
        
        $file = null;
        
        return $data;
    }
    
    public function readSelection(): string
    {
        echo "Do you want to syllabify a word (type 1) or a sentence (type 2)?";
        $line = trim(readline());
        
        while (strlen($line) === 0
            && ($line != self::WORD
                || $line != self::SENTENCE)) {
            echo "Do you want to syllabify a word or a sentence? ";
            $line = trim(readline());
        }
        
        return $line;
    }
    
    public function readWord(): string
    {
        echo "Enter word you want to syllabify: \n";
        return trim(readline());
    }
    
    public function readSentence()
    {
        return file_get_contents('src/Syllabus/log/sentence.txt');
    }
}
