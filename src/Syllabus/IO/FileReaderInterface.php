<?php
namespace Evaldas\Syllabus\IO;

interface FileReaderInterface{
    //reads from the file and puts data into array
    public function readFromFile(string $filePath) : array;
}
