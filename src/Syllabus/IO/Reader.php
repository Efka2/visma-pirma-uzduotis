<?php
namespace Evaldas\Syllabus\IO;

//require 'src\Syllabus\IO\FileReaderInterface.php';

use SplFileObject;

class Reader {

    private SplFileObject $fileObject;
    public function __construct(SplFileObject $fileObject)
    {
        $this->fileObject =$fileObject;
    }

    public function readFromFile() : array
    {
        $data = array();

        while (!$this->fileObject->eof()) {
            $data[] = trim($this->fileObject->fgets());
        }

        $file = null;

        return $data;
    }
}
