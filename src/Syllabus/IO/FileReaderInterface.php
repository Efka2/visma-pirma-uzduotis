<?php
namespace Syllabus\IO;

use SplFileObject;

interface FileReaderInterface{
    //reads from the file and puts data into array
    public function readFromFile(SplFileObject $fileObject) : array;
}
