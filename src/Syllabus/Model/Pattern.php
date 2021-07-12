<?php

namespace Syllabus\Model;

use Syllabus\Service\SyllabusHelper;

class Pattern
{
    private string $patternString;

    public function __construct(string $patternString)
    {
        $this->patternString = $patternString;
    }

    //todo trait?
    public function getPatterStringWithoutDots(): string
    {
        return str_replace('.','', $this->patternString);
    }

    public function getPatternStringWithoutNumbers(): string
    {
        //todo move number array to different place
        return str_replace(SyllabusHelper::$numbers,'', $this->patternString);
    }

    public function __toString(): string
    {
        return $this->patternString;
    }
}