<?php

namespace Syllabus\Service;

use Syllabus\Core\PatternCollection;

class RegexSyllabus
{
    protected array $numberArray;
    private string $word;
    private array $wordArray;
    private string $wordWithDots;

    public function syllabify(PatternCollection $allPatterns): string
    {
        $patterns = $this->findPatternsInWord($allPatterns);
        return $this->addDashesBetweenSyllables();
    }

    public function findPatternsInWord(PatternCollection $allPatterns): PatternCollection
    {
        $patterns = new PatternCollection();

        foreach ($allPatterns->getAll() as $pattern) {
            $patternWithoutNumbers = $pattern->getPatternStringWithoutNumbers();
            if ($this->isPatternBeginning($patternWithoutNumbers)) {
                $patternWithoutNumbers = $this->addStartRegexChar(
                    $patternWithoutNumbers
                );
            } elseif ($this->isPatternEnding($patternWithoutNumbers)) {
                $patternWithoutNumbers = $this->addEndingRegexChar(
                    $patternWithoutNumbers
                );
            }
            preg_match("/$patternWithoutNumbers/", $this->getWordWithDots(), $matches, PREG_OFFSET_CAPTURE);
            if (!empty($matches[0])) {
                $patterns->add($pattern);
                $this->numberArray = $this->populateNumbersArray(
                    $this->numberArray,
                    $pattern,
                    $matches[0][1]
                );
            }
        }

        return $patterns;
    }

    protected function addDashesBetweenSyllables(): string
    {
        $offset = -1;
        $word = $this->word;
        foreach ($this->numberArray as $key => $value) {
            if ($value % 2 !== 0 && $key != 1) {
                $word = substr_replace($word, '-', $key + $offset, 0);
                $offset++;
            }
        }

        return $word;
    }

    private function isPatternEnding(string $patternWithoutNumbers): bool
    {
        return preg_match("/\.$/", $patternWithoutNumbers);
    }

    private function isPatternBeginning(string $patternWithoutNumbers): bool
    {
        return preg_match("/^\./", $patternWithoutNumbers);
    }

    private function addEndingRegexChar(string $patternWithoutNumbers)
    {
        return preg_filter("#\.#", ".$", $patternWithoutNumbers);
    }

    private function addStartRegexChar(string $patternWithoutNumbers)
    {
        return preg_filter('#\.#', "^.", $patternWithoutNumbers);
    }

    public function getWordWithDots(): string
    {
        return $this->wordWithDots;
    }
}
