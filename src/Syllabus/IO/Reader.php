<?php
namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Core\Collection;
use Syllabus\Model\Pattern;

class Reader implements FileReaderInterface {

    public function readFromFileToCollection(SplFileObject $fileObject) : Collection
    {
        $data = new Collection();

        while (!$fileObject->eof()) {
            $pattern = new Pattern(trim($fileObject->fgets()));
            $data->add($pattern);
        }

        $file = null;

        return $data;
    }
}
