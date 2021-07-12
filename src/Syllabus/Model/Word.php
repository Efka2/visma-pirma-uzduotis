<?php


namespace Syllabus\Model;


class Word
{
    private string $word;
    private array $characters = array();

    public function __construct(string $word)
    {
        $this->word = $word;
        $this->characters = $this->splitWordIntoArray($this->word);
    }

    public function getCharacters(): array
    {
        return $this->characters;
    }

    private function splitWordIntoArray(string $word) : array
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