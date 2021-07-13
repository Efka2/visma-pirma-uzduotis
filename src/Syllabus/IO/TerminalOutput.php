<?php

namespace Syllabus\IO;

use Syllabus\Model\Result;

class TerminalOutput implements OutputInterface
{
    private Result $result;
    
    public function __construct(Result $result)
    {
        $this->result = $result;
    }
    
    public function output(): void
    {
        $word = $this->result->getWord();
        $patterns = $this->result->getFoundPatterns();
        $syllabifiedWord = $this->result->getSyllabifiedWord();
        $time = $this->result->getTime();
        
        echo "\nWord - $word\n";
        
        echo "\nFound patterns:\n";
        
        foreach ($patterns->getAll() as $pattern) {
            echo "$pattern\n";
        }
        
        echo "\nSyllabified word: $syllabifiedWord\n";
        
        echo sprintf("\nTime taken to syllabify: %f microseconds.\n", $time->f);
    }
}