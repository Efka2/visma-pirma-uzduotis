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
    
    //my abomination
    public function readSelection(string $message, array $options): string
    {
        $i = 0;
        while (true) {
            echo "$message";
            $line = trim(readline());
            
            foreach ($options as $option) {
                if ($line == $option) {
                    return $line;
                }
            }
        }
    }
    
    public
    function readWord(): string
    {
        echo "Enter word you want to syllabify: \n";
        
        return trim(readline());
    }
    
    public
    function readSentence()
    {
        return file_get_contents('src/Syllabus/log/sentence.txt');
    }
}
