<?php

namespace Syllabus\IO;

use SplFileObject;
use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollectionProxy;
use Syllabus\Model\Pattern;

class Reader implements FileReaderInterface, ReaderInterface
{
    public const IMPORT_FROM_DATABASE = 1;
    public const IMPORT_FROM_FILE = 2;
    public const ENTER_WORD_FROM_CLI = 3;
    public const ENTER_WORD_FROM_FILE = 4;


    private PatternCollectionProxy $proxy;

    public function __construct(PatternCollectionProxy $proxy)
    {
        $this->proxy = $proxy;
    }

    public function readFromFileToCollection(string $fileName): CollectionInterface
    {
        $fileObject = new SplFileObject($fileName);
        while (!$fileObject->eof()) {
            $pattern = new Pattern(trim($fileObject->fgets()));
            $this->proxy->add($pattern);
        }

        $fileObject = null;

        return $this->proxy;
    }

    public function readSelection(string $message, array $options): string
    {
        while (true) {
            echo "$message ";
            $line = trim(readline());

            foreach ($options as $option) {
                if ($line == $option) {
                    return $line;
                }
            }
        }
    }

    public function readFromCli(): string
    {
        echo "Enter word you want to syllabify: \n";

        return trim(readline());
    }

    public function readWordFromFile(string $filename)
    {
        return file_get_contents($filename);
    }
}
