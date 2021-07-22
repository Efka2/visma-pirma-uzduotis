<?php

namespace Syllabus\Model;

class Word
{
    private string $wordString;
    private string $syllabifiedWord;
    
    public function getSyllabifiedWord(): string
    {
        return $this->syllabifiedWord;
    }
    
    public function getWordString(): string
    {
        return $this->wordString;
    }
    
    public function setSyllabifiedWord(string $syllabifiedWord): void
    {
        $this->syllabifiedWord = $syllabifiedWord;
    }
    
    public function setWordString(string $wordString): void
    {
        $this->wordString = $wordString;
    }
    
    public function __toString()
    {
        return $this->wordString;
    }
}