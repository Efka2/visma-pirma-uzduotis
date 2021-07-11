<?php
namespace Syllabus\IO;

use Syllabus\Core\Collection;

class Output{

    public static function printAnswerToTerminal(string $word, Collection $patterns, string $syllabifiedWord, \DateInterval $time)
    {
        echo "\nWord - $word\n";

        echo "\nFound patterns:\n";

        foreach ($patterns->getAll() as $pattern){
            echo "$pattern\n";
        }

        echo "\nSyllabified word: $syllabifiedWord\n";

        echo sprintf("\nTime taken to syllabify: %f microseconds.\n", $time->f);
    }
}