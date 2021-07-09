<?php

namespace Evaldas\Syllabus\Service;

class Syllabus
{
    private array $numbers = [0,1,2,3,4,5,6,7,8,9];
    private array $wordArray;
    public array $numberArray;
    private string $wordWithDots;

    public string $word;

    public function __construct(string $word)
    {
        $this->word = $word;
        $this->wordArray = $this->setWordArray($word);
        $this->numberArray = $this->setNumberArray($this->wordArray);
        $this->wordWithDots = '.' . $word . '.';
    }

    private function setWordArray(string $word) : array
    {
        return $wordArray = str_split($word);
    }

    private function setNumberArray(array $wordArray){
        for($i = 0; $i< count($wordArray)  ; $i++){
            $numberArray[$i] = 0;
        }
        return $numberArray;
    }

    public function findPatternsInWord(array $patternArray) : array
    {
        foreach ($patternArray as $pattern){

            $pattern_without_number = str_replace($this->numbers,'', $pattern);
            $position = strpos( $this->wordWithDots, $pattern_without_number);

            if($position !== false){
                $this->numberArray = $this->populateNumbersArray($this->numberArray,$pattern,$position);
            }
        }
        return $this->numberArray;
    }

    private function populateNumbersArray(array $numberArray, string $pattern, int $position): array
    {
        $patternChars = str_split($pattern);

        foreach ($patternChars as $char){
            if($position == count($numberArray)) continue;
            if(is_numeric($char) && $char > $numberArray[$position]){
                $numberArray[$position] = $char;
            }
            else $position++;
        }
        return $numberArray;
    }

    public function syllabifyWord(): string{
        $k = -1;
        foreach ($this->numberArray as $key => $value){
            if($value % 2 !== 0){
                $this->word = substr_replace($this->word, '-', $key+$k, 0);
                $k++;
            }
        }
        return $this->word;
    }
}