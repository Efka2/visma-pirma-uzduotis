<?php

namespace Syllabus\Core;

use DateTime;
use Syllabus\Handler\PatternHandler;
use Syllabus\Handler\PatternWordHandler;
use Syllabus\Handler\WordHandler;
use Syllabus\IO\FileReaderInterface;
use Syllabus\IO\TerminalOutput;
use Syllabus\IO\Reader;
use Syllabus\Model\Result;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;

class Application
{
    private Reader $reader;
    private Syllabus $syllabus;
    private WordHandler $wordHandler;
    private PatternWordHandler $patternWordHandler;
    private PatternHandler $patternHandler;

    public function __construct(
        Reader $reader,
        Syllabus $syllabus,
        WordHandler $wordHandler,
        PatternWordHandler $patternWordHandler,
        PatternHandler $patternHandler
    ) {
        $this->reader = $reader;
        $this->syllabus = $syllabus;
        $this->wordHandler = $wordHandler;
        $this->patternWordHandler = $patternWordHandler;
        $this->patternHandler = $patternHandler;
    }

    public function run(): void
    {
        $printPatterns = false;

        $sourceSelection = $this->reader->readSelection(
            "Do you want to use patterns from database (1) or file (2)?
            (Type in the number in brackets): ",
            [Reader::IMPORT_FROM_DATABASE, Reader::IMPORT_FROM_FILE]
        );

        $wordImportSelection = $this->reader->readSelection(
            "Do you want to enter the word from CLI (3) or file (4): ",
            [Reader::ENTER_WORD_FROM_CLI, Reader::ENTER_WORD_FROM_FILE]
        );

        $allPatterns = $this->getAllPatterns();

        if ($sourceSelection == Reader::IMPORT_FROM_DATABASE) {
            $printPatterns = true;
        }

        $readWord = $this->readWord($wordImportSelection);

        $word = new Word($readWord);

        $timeStart = new DateTime();

        //todo change this abomination somehow
        //change it to result maybe
        if ($this->wordHandler->isWordInDatabase($word)) {
            $word = $this->wordHandler->getByString($word->getWordString());
            $wordId = $this->wordHandler->getWordId($word);
            $syllabifiedWord = $word->getSyllabifiedWord();
            $foundPatters = $this->patternWordHandler->getPatterns($wordId);
        } else {
            $syllabifiedWord = $this->syllabus->hyphenate($word, $allPatterns);
            $foundPatters = $this->syllabus->findPatternsInWord($word, $allPatterns);

            if ($wordImportSelection == Reader::ENTER_WORD_FROM_CLI && $sourceSelection == Reader::IMPORT_FROM_DATABASE) {
                $word->setSyllabifiedWord($syllabifiedWord);
                $this->wordHandler->insert($word);
                $this->patternWordHandler->insert($word, $foundPatters);
            }
        }

        $diff = $timeStart->diff(new DateTime());

        $result = new Result($word, $syllabifiedWord, $foundPatters, $diff);

        $output = new TerminalOutput($result, $printPatterns);
        $output->output();
    }

    //todo move these to reader class?
    //todo another abomination with if else
    private function getAllPatterns(): CollectionInterface
    {
        $isTableEmpty = $this->patternHandler->isTableEmpty();

        if ($isTableEmpty) {
            $allPatterns = $this->reader->readFromFileToCollection(FileReaderInterface::DEFAULT_PATTERN_LINK);
            foreach ($allPatterns->getAll() as $pattern) {
                $this->patternHandler->insert($pattern);
            }
            return $allPatterns;
        }
        return $allPatterns = $this->patternHandler->index();
    }

    private function readWord(string $wordImportSelection): string
    {
        if ($wordImportSelection == Reader::ENTER_WORD_FROM_CLI) {
            $readWord = $this->reader->readFromCli();
        }
        if ($wordImportSelection == Reader::ENTER_WORD_FROM_FILE) {
            $readWord = $this->reader->readWordFromFile('src/log/word.txt');
        }
        return $readWord;
    }
}
