<?php

namespace Syllabus\Core;

use DateTime;
use Syllabus\IO\FileReaderInterface;
use Syllabus\IO\Output;
use Syllabus\IO\Reader;
use Syllabus\log\LoggerInterface;
use Syllabus\Model\Result;
use Syllabus\Service\Syllabus;
use SplFileObject;

class Application
{
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function run(): void
    {
        $fileName = FileReaderInterface::DEFAULT_PATTERN_LINK;
        $fileReader = new SplFileObject(
            $fileName
        );
        $reader = new Reader();
        $allPatterns = $reader->readFromFileToCollection($fileReader);
        
        $this->logger->info("File $fileName is read");
        
        $word = $reader->readFromTerminal();
        
        $timeStart = new DateTime();
        
        $syllabus = new Syllabus($word);
        $syllabifiedWord = $syllabus->syllabify($allPatterns);
        
        $this->logger->info(
            "Word $word had these patters:",
            $syllabus->findPatternsInWord($allPatterns)->getAll()
        );
        
        $diff = $timeStart->diff(new DateTime());
        
        $this->logger->info("Time taken to syllabify: $diff->f microseconds");
        
        $result = new Result(
            $word,
            $syllabifiedWord,
            $syllabus->findPatternsInWord($allPatterns),
            $diff
        );
        
        Output::printAnswerToTerminal($result);
    }
}