<?php

namespace Syllabus\IO;

class Output
{
    private OutputInterface $output;
    
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }
    
    public function output()
    {
        $this->output->output();
    }
}