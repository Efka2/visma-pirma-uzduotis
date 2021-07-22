<?php

namespace Syllabus\Service;

use DateTime;
use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollection;
use Syllabus\Model\Word;

class Syllabus extends SyllabusHelper
{
    public function syllabify(Word $word, $patternArray): string
    {
        $this->setWord($word);
        $this->findPatternsInWord($patternArray);
        return $this->addDashesBetweenSyllables();
    }
    
    public function findPatternsInWord(CollectionInterface $patterns
    ): PatternCollection {
        $foundPatterns = new PatternCollection();
        
        foreach ($patterns->getAll() as $pattern) {
            $patternWithoutNumbers = $pattern->getPatternStringWithoutNumbers();
            
            $position = strpos(
                $this->getWordWithDots(),
                $patternWithoutNumbers
            );
            
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