<?php

namespace Syllabus\IO;

use Syllabus\Model\Result;

class Output
{
    public static function printAnswerToTerminal(Result $result): void
    {
        $word = $result->getWord();
        $patterns = $result->getFoundPatterns();
        $syllabifiedWord = $result->getSyllabifiedWord();
        $time = $result->getTime();
        
        echo "\nWord - $word\n";
        
        echo "\nFound patterns:\n";
        
        foreach ($patterns->getAll() as $pattern) {
            echo "$pattern\n";
        }
        
        echo "\nSyllabified word: $syllabifiedWord\n";
        
        echo sprintf("\nTime taken to syllabify: %f microseconds.\n", $time->f);
    }
}