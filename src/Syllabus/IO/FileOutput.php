<?php

namespace Syllabus\IO;

use Syllabus\Model\Result;

class FileOutput implements OutputInterface
{
    private Result $result;
    private string $file;
    
    public function __construct(Result $result,string $file)
    {
        $this->result = $result;
        $this->file = $file;
    }
    
    public function output(): void
    {
        $word = $this->result->getWord();
        $patterns = $this->result->getFoundPatterns();
        $syllabifiedWord = $this->result->getSyllabifiedWord();
        $time = $this->result->getTime();
    
        $content = "\nWord - $word\n";
        $content .= "\nFound patterns:\n";
        
        foreach ($patterns->getAll() as $pattern) {
            $content .= "$pattern\n";
        }
        
        $content .= "\nSyllabified word: $syllabifiedWord\n";
        
        $content .= sprintf("\nTime taken to syllabify: %f microseconds.\n", $time->f);
        
        file_put_contents($this->file,$content);
    }
}