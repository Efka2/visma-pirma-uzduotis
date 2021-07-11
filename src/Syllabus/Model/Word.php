<?php


namespace Syllabus\Model;


class Word
{
    private string $word;
    private array $wordArray = array();


    public function __construct(string $word)
    {
        $this->word = $word;
        $this->wordArray = $this->splitWordArray($this->word);
    }

    public function getWordArray(): array
    {
        return $this->wordArray;
    }

    private function splitWordArray(string $word) : array
    {
        return $wordArray = str_split($word);
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function setWord(string $word): void
    {
        $this->word = $word;
    }

}