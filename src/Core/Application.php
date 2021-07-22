<?php

namespace Syllabus\Core;

use DateTime;
use Psr\Log\LoggerInterface;
use Syllabus\Handler\PatternHandler;
use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;
use Syllabus\IO\FileReaderInterface;
use Syllabus\IO\TerminalOutput;
use Syllabus\IO\Reader;
use Syllabus\Model\Result;
use SplFileObject;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;

class Application
{
    private LoggerInterface $logger;
    private Reader $reader;
    private Syllabus $syllabus;
    private WordHandler $wordHandler;
    private PatternWordHandler $patternWordHandler;
    private PatternHandler $patternHandler;

    public function __construct(
        Logger $logger,
        Reader $reader,
        Syllabus $syllabus,
        WordHandler $wordHandler,
        PatternWordHandler $patternWordHandler,
        PatternHandler $patternHandler
    ) {
        $this->logger = $logger;
        $this->reader = $reader;
        $this->syllabus = $syllabus;
        $this->wordHandler = $wordHandler;
        $this->patternWordHandler = $patternWordHandler;
        $this->patternHandler = $patternHandler;
    }

    public function run(): void
    {
        $foundPatters = new PatternCollection();
        $word = new Word();
        $printPatterns = FALSE;

        $sourceSelection = $this->reader->readSelection(
            "Do you want to use patterns from database (1) or file (2)?
            (Type in the number in brackets): ",
            [Reader::IMPORT_FROM_DATABASE, Reader::IMPORT_FROM_FILE]
        );

        $wordImportSelection = $this->reader->readSelection(
            "Do you want to enter the word from CLI (3) or file (4): ",
            [Reader::ENTER_WORD_FROM_CLI, Reader::ENTER_WORD_FROM_FILE]
        );

        $allPatterns = $this->getAllPatterns($sourceSelection);

        if ($sourceSelection == Reader::IMPORT_FROM_DATABASE) {
            $printPatterns = TRUE;
        }

        if ($this->patternHandler->isTableEmpty()) {
            foreach ($allPatterns->getAll() as $pattern) {
                $this->patternHandler->insert($pattern);
            }
        }

        if ($wordImportSelection == Reader::ENTER_WORD_FROM_CLI) {
            $wordFromCLI = $this->reader->readFromCli();
            $word->setWordString($wordFromCLI);
        } else {
            $wordFromFile = $this->reader->readWordFromFile('src/log/word.txt');
            $word->setWordString($wordFromFile);
        }

        $timeStart = new DateTime();

        //todo change this somehow
        if ($this->wordHandler->isWordInDatabase($word)) {
            $word = $this->wordHandler->get($word->getWordString());
            $syllabifiedWord = $word->getSyllabifiedWord();
            $wordId = $this->wordHandler->getWordId($word);
            $foundPatters = $this->patternWordHandler->getPatterns($wordId);
        } else {
            $syllabifiedWord = $this->syllabus->syllabify($word, $allPatterns);
            $foundPatters = $this->syllabus->findPatternsInWord($allPatterns);

            if ($wordImportSelection == Reader::ENTER_WORD_FROM_CLI
                && $sourceSelection == Reader::IMPORT_FROM_DATABASE
            ) {
                $word->setSyllabifiedWord($syllabifiedWord);
                $this->patternWordHandler->insert($foundPatters, $word);
            }
        }

        $diff = $timeStart->diff(new DateTime());
        $this->logger->info("Time taken to syllabify: $diff->f microseconds");

        $result = new Result($word, $syllabifiedWord, $foundPatters, $diff);

        $output = new TerminalOutput($result, $printPatterns);
        $output->output();
    }

    //todo move these to reader class?
    //todo another abomination with if else
    private function getAllPatterns(string $selection): CollectionInterface
    {
        if ($selection == Reader::IMPORT_FROM_DATABASE) {
            if ($this->patternHandler->isTableEmpty()) {
                $allPatterns = $this->readFromFile();
            } else {
                $allPatterns = $this->patternHandler->index();
            }
        } else {
            $allPatterns = $this->readFromFile();
        }
        return $allPatterns;
    }

    private function readFromFile(): CollectionInterface
    {
        $fileName = FileReaderInterface::DEFAULT_PATTERN_LINK;
        $fileReader = new SplFileObject($fileName);
        $allPatterns = $this->reader->readFromFileToCollection($fileReader);
        $this->logger->info("Read patterns from file $fileName");

        return $allPatterns;
    }
}