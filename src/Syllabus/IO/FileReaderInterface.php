<?php
namespace Syllabus\IO;

require_once ('src/Syllabus/Core/Collection.php');

use SplFileObject;
use Syllabus\Core\Collection;

interface FileReaderInterface{
    //reads from the file and puts data into array
    public function readFromFile(SplFileObject $fileObject) : array;
}
