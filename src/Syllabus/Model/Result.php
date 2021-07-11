<?php


namespace Syllabus\Model;

class Result
{
    private array $resultArray = array();

    public function __construct()
    {
        $this->resultArray = $this->setNumberArray();
    }

    private function setNumberArray(array $wordArray){
        for($i = 0; $i< count($wordArray); $i++){
            $numberArray[$i] = 0;
        }
        return $numberArray;
    }

    public function getResultArray() : array{
        return $this->resultArray;
    }
}