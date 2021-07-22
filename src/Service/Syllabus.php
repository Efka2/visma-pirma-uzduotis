<?php

namespace Syllabus\Service;

use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollection;
use Syllabus\Model\Word;

class Syllabus
{
    public const NUMBERS = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    protected array $numberArray;
    private string $word;
    private array $wordArray;
    private string $wordWithDots;

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

            if ($position !== FALSE) {
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

    public function getWordArray(): array
    {
        return $this->wordArray;
    }

    public function getWordWithDots(): string
    {
        return $this->wordWithDots;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getNumberArray(): array
    {
        return $this->numberArray;
    }

    protected function setWordArray(string $word): array
    {
        return $wordArray = str_split($word);
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

    protected function populateNumbersArray(array $numberArray, string $pattern, int $position): array
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

    protected function setWord(Word $word)
    {
        $this->word = $word->getWordString();
        $this->wordArray = $this->setWordArray($word);
        $this->numberArray = $this->setNumberArray($this->wordArray);
        $this->wordWithDots = '.' . $word . '.';
    }

    private function setNumberArray(array $wordArray)
    {
        for ($i = 0; $i < count($wordArray); $i++) {
            $numberArray[$i] = 0;
        }

        return $numberArray;
    }
}