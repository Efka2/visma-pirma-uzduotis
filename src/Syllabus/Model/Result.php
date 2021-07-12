<?php


namespace Syllabus\Model;

use Syllabus\Core\Collection;

class Result
{
//    private array $resultArray = array();
    private Collection $foundPatterns;
    private string $syllabifiedWord;
    private string $word;

    private \DateInterval $time;


    public function __construct(string $word, string $syllabifiedWord,Collection $foundPatterns, \DateInterval $time)
    {
        $this->word = $word;
        $this->syllabifiedWord = $syllabifiedWord;
        $this->foundPatterns = $foundPatterns;
        $this->time = $time;
    }


    public function getWord(): string
    {
        return $this->word;
    }


    public function getFoundPatterns(): Collection
    {
        return $this->foundPatterns;
    }


    public function getSyllabifiedWord(): string
    {
        return $this->syllabifiedWord;
    }
    public function getTime(): \DateInterval
    {
        return $this->time;
    }



    private function setNumberArray(array $wordArray){
        for($i = 0; $i< count($wordArray); $i++){
            $numberArray[$i] = 0;
        }
        return $numberArray;
    }

//    public function getResultArray() : array{
//        return $this->resultArray;
//    }
}