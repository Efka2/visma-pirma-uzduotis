<?php
namespace Syllabus\IO;

require_once('FileReaderInterface.php');
use SplFileObject;

class Reader implements FileReaderInterface {

    public function readFromFile(SplFileObject $fileObject) : array
    {
        $data = array();

        while (!$fileObject->eof()) {
            $data[] = trim($fileObject->fgets());
        }

        $file = null;

        return $data;
    }
}
