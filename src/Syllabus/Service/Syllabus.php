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

    public function findPatternsInWord(PatternCollection $patterns): PatternCollection
    {
        $foundPatterns = new PatternCollection();

        foreach ($patterns->getAll() as $pattern) {
            $patternWithoutNumbers = $pattern->getPatternStringWithoutNumbers();
            $position = strpos( $this->wordWithDots, $patternWithoutNumbers);

            if ($position !== false) {
                $foundPatterns->add($pattern);
                $this->numberArray = $this->populateNumbersArray($this->numberArray,$pattern,$position);
            }
        }
        return $foundPatterns;
    }

    private function addDashesBetweenSyllables(): string
    {
        $offset = -1;
        $word = $this->word;
        foreach ($this->numberArray as $key => $value) {
            if ($value % 2 !== 0) {
                $word = substr_replace($word, '-', $key+$offset, 0);
                $offset++;
            }
        }
        return $word;
    }

    private function populateNumbersArray(array $numberArray, string $pattern, int $position): array
    {
        $patternChars = str_split($pattern);

        foreach ($patternChars as $char) {
            if ($position == count($numberArray)) continue;
            if (is_numeric($char) && $char > $numberArray[$position]) {
                $numberArray[$position] = $char;
            } else $position++;
        }
        return $numberArray;
    }
}