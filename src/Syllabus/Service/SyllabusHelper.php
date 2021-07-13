<?php

namespace Syllabus\Service;

class SyllabusHelper
{
    public const NUMBERS = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    protected array $numberArray;
    private string $word;
    private array $wordArray;
    private string $wordWithDots;
    
    public function __construct(string $word)
    {
        $this->word = $word;
        $this->wordArray = $this->setWordArray($word);
        $this->numberArray = $this->setNumberArray($this->wordArray);
        $this->wordWithDots = '.'.$word.'.';
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
            if ($value % 2 !== 0) {
                $word = substr_replace($word, '-', $key + $offset, 0);
                $offset++;
            }
        }
        
        return $word;
    }
    
    protected function populateNumbersArray(
        array $numberArray,
        string $pattern,
        int $position
    ): array {
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
    
    private function setNumberArray(array $wordArray)
    {
        for ($i = 0; $i < count($wordArray); $i++) {
            $numberArray[$i] = 0;
        }
        
        return $numberArray;
    }
    
}