<?php

namespace Syllabus\Service;

use Syllabus\Core\PatternCollection;

class Syllabus extends SyllabusHelper
{
    public function syllabify($patternArray): string
    {
        $this->findPatternsInWord($patternArray);
        
        return $this->addDashesBetweenSyllables();
    }
    
    public function findPatternsInWord(PatternCollection $patterns
    ): PatternCollection {
        $foundPatterns = new PatternCollection();
        
        foreach ($patterns->getAll() as $pattern) {
            $patternWithoutNumbers = $pattern->getPatternStringWithoutNumbers();
            $position = strpos($this->getWordWithDots(), $patternWithoutNumbers);
            
            if ($position !== false) {
                $foundPatterns->add($pattern);
                $this->numberArray = $this->populateNumbersArray(
                    $this->numberArray,
                    $pattern,
                    $position
                );
            }
        }
        
        return $foundPatterns;
    }
}