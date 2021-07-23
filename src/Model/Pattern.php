<?php

namespace Syllabus\Model;

use Syllabus\Service\Syllabus;

class Pattern
{
    private string $patternString;

    public function __construct(string $patternString)
    {
        $this->patternString = $patternString;
    }

    public function getPatterString(): string
    {
        return $this->patternString;
    }

    public function getPatternStringWithoutNumbers(): string
    {
        return str_replace(Syllabus::NUMBERS, '', $this->patternString);
    }

    public function __toString(): string
    {
        return $this->patternString;
    }
}
