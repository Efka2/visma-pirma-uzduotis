<?php
namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Core\Collection;

interface FileReaderInterface{
    //reads from the file and puts data into array
    public function readFromFile(SplFileObject $fileObject) : Collection;
}
