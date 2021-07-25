<?php

namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Core\Collection;
use Syllabus\Core\CollectionInterface;

interface FileReaderInterface
{
    public const DEFAULT_PATTERN_LINK = "https://gist.githubusercontent.com/cosmologicon/1e7291714094d71a0e256783161415"
                                        . "86/raw/006f7e9093dc7ad72b12ff9f1da649822e56d39d/tex-hyphenation-patterns.txt";

    public function readFromFileToCollection(string $filename): CollectionInterface;
}
