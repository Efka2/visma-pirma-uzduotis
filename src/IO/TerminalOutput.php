<?php

namespace Syllabus\IO;

use Syllabus\Model\Result;

class TerminalOutput
{
    private Result $result;
    private bool $printFoundPatters;

    public function __construct(Result $result, bool $printFoundPatterns = false)
    {
        $this->result = $result;
        $this->printFoundPatters = $printFoundPatterns;
    }

    public function output(): void
    {
        $word = $this->result->getWord();
        $syllabifiedWord = $this->result->getSyllabifiedWord();
        $patterns = $this->result->getFoundPatterns();
        $time = $this->result->getTime();
        echo "\nWord - $word\n";

        if ($this->printFoundPatters && $patterns != null) {
            echo "\nFound patterns:\n";
            foreach ($patterns as $pattern) {
                echo "$pattern\n";
            }
        }

        echo "\nSyllabified word: $syllabifiedWord\n";

        echo sprintf("\nTime taken to syllabify: %f microseconds.\n", $time->f);
    }
}
