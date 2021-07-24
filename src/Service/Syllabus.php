<?php

namespace Syllabus\Service;

use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollection;
use Syllabus\Model\Word;

class Syllabus
{
    public const NUMBERS = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    private Word $word;
    private array $numberArray;
    private array $wordArray;

    public function syllabify(Word $word, CollectionInterface $patternArray): string
    {
        $this->setWord($word);
        $this->findPatternsInWord($word, $patternArray);
        return $this->addDashesBetweenSyllables();
    }

    public function findPatternsInWord(Word $word, CollectionInterface $patterns): PatternCollection
    {
        $foundPatterns = new PatternCollection();
        $this->setWord($word);

        foreach ($patterns->getAll() as $pattern) {
            $patternWithoutNumbers = $pattern->getPatternWithoutNumbers();
            $position = strpos(".$word.", $patternWithoutNumbers);

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

    private function setWordArray(Word $word): array
    {
        return $this->wordArray = str_split($word);
    }

    private function addDashesBetweenSyllables(): string
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

    private function populateNumbersArray(array $numberArray, string $pattern, int $position): array
    {
        $patternChars = str_split($pattern);

        foreach ($patternChars as $char) {
            if ($position == count($numberArray)) {
                continue;
            }
            if (is_numeric($char) && $char > $numberArray[$position]) {
                $numberArray[$position] = $char;
            } else {
                $position++;
            }
        }

        return $numberArray;
    }

    private function setWord(Word $word)
    {
        $this->word = $word;
        $this->wordArray = $this->setWordArray($word);
        $this->numberArray = $this->setNumberArray($this->wordArray);
    }

    private function setNumberArray(array $wordArray): array
    {
        $size = count($wordArray);
        for ($i = 0; $i < $size; $i++) {
            $numberArray[$i] = 0;
        }

        return $numberArray;
    }
}
