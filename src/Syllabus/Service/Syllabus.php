<?php

namespace Syllabus\Service;

use Syllabus\Core\Collection;

require_once ('src/Syllabus/Core/Collection.php');
require_once ('SyllabusHelper.php');

class Syllabus extends SyllabusHelper
{
    public function __construct(string $word)
    {
        parent::__construct($word);
    }

    public function syllabify($patternArray):string{
        $this->findPatternsInWord($patternArray);
        $finalWord = $this->addDashesToWord();
        return $finalWord;
    }

    public function addDashesToWord(): string{
        $offset = -1;
        foreach ($this->numberArray as $key => $value){
            if($value % 2 !== 0){
                $this->word = substr_replace($this->word, '-', $key+$offset, 0);
                $offset++;
            }
        }
        return $this->word;
    }

    private function findPatternsInWord(array $patternArray) : array
    {
        foreach ($patternArray as $pattern){

            $pattern_without_number = str_replace(self::NUMBER_ARRAY,'', $pattern);
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
}