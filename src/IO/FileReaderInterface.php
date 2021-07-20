<?php

namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Core\Collection;

interface FileReaderInterface
{
    //reads from the file and puts data into array
    public const DEFAULT_PATTERN_LINK = "https://gist.githubusercontent.com/cosmologicon/1e7291714094d71a0e25678316141586/raw/006f7e9093dc7ad72b12ff9f1da649822e56d39d/tex-hyphenation-patterns.txt";

    public function readFromFileToCollection(SplFileObject $fileObject): Collection;
}
