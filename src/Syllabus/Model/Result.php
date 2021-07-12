<?php

namespace Syllabus\Model;

use Syllabus\Core\PatternCollection;

class Result
{
    private PatternCollection $foundPatterns;
    private string $syllabifiedWord;
    private string $word;
    private \DateInterval $time;

    public function __construct(string $word, string $syllabifiedWord, PatternCollection $foundPatterns, \DateInterval $time)
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


    public function getFoundPatterns(): PatternCollection
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
}