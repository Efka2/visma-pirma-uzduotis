<?php
namespace Syllabus\IO;

require_once('FileReaderInterface.php');
require_once('src/Syllabus/Model/Pattern.php');
require_once('src/Syllabus/Core/Collection.php');

use SplFileObject;
use Syllabus\Core\Collection;
use Syllabus\Model\Pattern;

class Reader implements FileReaderInterface {

    public function readFromFile(SplFileObject $fileObject) : array
    {
        $data = array();

        while (!$fileObject->eof()) {
            $pattern = new Pattern(trim($fileObject->fgets()));
            $data[] = $pattern;
        }

        $file = null;

        return $data;
    }
}
