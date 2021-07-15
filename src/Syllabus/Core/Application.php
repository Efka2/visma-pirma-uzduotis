<?php

namespace Syllabus\Core;

use DateTime;
use Syllabus\Controller\PatternController;
use Syllabus\Controller\PatternWordController;
use Syllabus\Controller\WordController;
use Syllabus\Database\Database;
use Syllabus\IO\FileReaderInterface;
use Syllabus\IO\Output;
use Syllabus\IO\TerminalOutput;
use Syllabus\IO\Reader;
use Syllabus\log\LoggerInterface;
use Syllabus\Model\Result;
use SplFileObject;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;

class Application
{
    private LoggerInterface $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function run(): void
    {
        $reader = new Reader();
        $syllabus = new Syllabus();
        $foundPatters = new PatternCollection();
        $database = new Database();
        $wordController = new WordController($database);
        $word = new Word();
        $printPatterns = false;
        $patternController = new PatternController($database);

        if($patternController->isTableEmpty()){
            echo "xui";die();
        }
        
        //todo numbers are hardcoded though :(
        $sourceSelection = $reader->readSelection(
            "Do you want to use patterns from database (1) or file (2)?
            (Type in the number in brackets): ",
            array(Reader::IMPORT_FROM_DATABASE, Reader::IMPORT_FROM_FILE)
        );
        
        $wordImportSelection = $reader->readSelection(
            "Do you want to enter the word from CLI (3) or file (4): ",
            array(Reader::ENTER_WORD_FROM_CLI, Reader::ENTER_WORD_FROM_FILE)
        );
    
        $allPatterns = $this->getAllPatterns($sourceSelection, $database);
        
        if ($wordImportSelection == Reader::ENTER_WORD_FROM_CLI) {
            $wordFromCLI = $reader->readWordFromCLI();
            $word->setWordString($wordFromCLI);
        } else {
            $wordFromFile = $reader->readWordFromFile('src/Syllabus/log/word.txt');
            $word->setWordString($wordFromFile);
        }
        
        $timeStart = new DateTime();
        
        if ($this->isWordInDatabase($wordController, $word)) {
            $word = $wordController->get($word);
            $syllabifiedWord = $word->getSyllabifiedWord();
            $patternWordController = new PatternWordController($database);
            $foundPatters = $patternWordController->getPatterns($word);
        } else {
            $syllabifiedWord = $syllabus->syllabify($word, $allPatterns);
            $foundPatters = $syllabus->findPatternsInWord($allPatterns);
            
            if ($wordImportSelection == Reader::ENTER_WORD_FROM_CLI
                && $sourceSelection == Reader::IMPORT_FROM_DATABASE
            ) {
                $word->setSyllabifiedWord($syllabifiedWord);
                $this->insertWordAndPatternsIntoDatabase(
                    $database,
                    $word,
                    $foundPatters
                );
            }
        }
        
        if ($sourceSelection == Reader::IMPORT_FROM_DATABASE) {
            $printPatterns = true;
        }
        
        $diff = $timeStart->diff(new DateTime());
        $this->logger->info("Time taken to syllabify: $diff->f microseconds");
        
        $result = new Result($word, $syllabifiedWord, $foundPatters, $diff);
        
        $output = new Output(new TerminalOutput($result, $printPatterns));
        $output->output();
    }
    
    //todo move these to reader class?
    private function getAllPatterns(
        string $selection,
        $database
    ): PatternCollection {
        if ($selection == Reader::IMPORT_FROM_DATABASE) {
            $allPatterns = $this->readFromDatabase($database);
        } else {
            $allPatterns = $this->readFromFile();
        }
        
        return $allPatterns;
    }
    
    private function readFromDatabase(Database $database): PatternCollection
    {
        $controller = new PatternController($database);
        $allPatterns = $controller->index();
        $this->logger->info("Read patterns from database");
        
        return $allPatterns;
    }
    
    private function readFromFile(): PatternCollection
    {
        $reader = new Reader();
        $fileName = FileReaderInterface::DEFAULT_PATTERN_LINK;
        $fileReader = new SplFileObject($fileName);
        $allPatterns = $reader->readFromFileToCollection($fileReader);
        $this->logger->info("Read patterns from file $fileName");
        
        return $allPatterns;
    }
    
    private function insertWordAndPatternsIntoDatabase(
        Database $database,
        Word $word,
        PatternCollection $foundPatters
    ): void {
        $wordController = new PatternWordController($database);
        $wordController->insert($foundPatters, $word);
    }
    
    private function isWordInDatabase(
        WordController $wordController,
        Word $word
    ): bool {
        $allWords =  $wordController->index();
        
        if(!empty($allWords)){
            foreach ($allWords as $wordFromDb) {
                if ($wordFromDb == $word) {
                    echo "This word was already syllabified!\n";
            
                    return true;
                }
            }
        }
        
        return false;
    }
}