<?php

namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Controller\PatternController;
use Syllabus\Core\PatternCollection;
use Syllabus\Database\Database;
use Syllabus\Model\Pattern;

class Reader implements FileReaderInterface
{
    //todo how to rename these?
    public const IMPORT_FROM_DATABASE = 1;
    public const IMPORT_FROM_FILE = 2;
    public const ENTER_WORD_FROM_CLI = 3;
    public const ENTER_WORD_FROM_FILE = 4;
    
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
            echo "$message ";
            $line = trim(readline());
            
            foreach ($options as $option) {
                if ($line == $option) {
                    return $line;
                }
            }
        }
    }
    
    public function readWordFromCLI(): string
    {
        echo "Enter word you want to syllabify: \n";
        
        return trim(readline());
    }
    
    public function readSentence()
    {
        return file_get_contents('src/Syllabus/log/sentence.txt');
    }
}
