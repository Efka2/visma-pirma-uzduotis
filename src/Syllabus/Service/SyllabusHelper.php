<?php

namespace Syllabus\Service;

class SyllabusHelper
{
    public const NUMBERS = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    protected string $word;
    protected array $wordArray;
    protected string $wordWithDots;
    protected array $numberArray;
    
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
    
    private function setNumberArray(array $wordArray)
    {
        for ($i = 0; $i < count($wordArray); $i++) {
            $numberArray[$i] = 0;
        }
        
        return $numberArray;
    }
    
}