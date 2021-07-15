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
        
        //todo numbers are hardcoded though :(
        $importSelection = $reader->readSelection(
            "Do you want to use patterns from database (1) or file (2)?
            (Type in the number in brackets): ",
            array(Reader::IMPORT_FROM_DATABASE, Reader::IMPORT_FROM_FILE)
        );
        
        $database = new Database();
        
        $allPatterns = $this->getAllPatterns($importSelection, $database);
        
        $wordImportSelection = $reader->readSelection(
            "Do you want to enter the word from CLI (3) or file (4): ",
            array(Reader::ENTER_WORD_FROM_CLI, Reader::ENTER_WORD_FROM_FILE)
        );
        
        $word = new Word();
        
        if ($wordImportSelection == Reader::ENTER_WORD_FROM_CLI) {
            $wordFromCLI = $reader->readWordFromCLI();
            $word->setWordString($wordFromCLI);
        } else {
            //todo enter from file
            exit();
//            $word = $reader->readWordFromFile($file);
        }
        
        $wordController = new WordController($database);
        
        if ($this->checkIfWordWasSyllabified($wordController,$database, $word)) {
            //todo makaronai, reikia pakeisti, kad syllabus nereikalautu word construkuryje
            $word = $wordController->get($word);
            $syllabifiedWord = $word->getSyllabifiedWord();
            $syllabus = new Syllabus($word->getWordString());
    
            $foundPatters = new PatternCollection();
            if($importSelection == Reader::IMPORT_FROM_DATABASE){
                $foundPatters = $syllabus->findPatternsInWord($allPatterns);
            }
        } else {
            $syllabus = new Syllabus($word);
            $syllabifiedWord = $syllabus->syllabify($allPatterns);
            
            $foundPatters = new PatternCollection();
            if($importSelection == Reader::IMPORT_FROM_DATABASE){
                $foundPatters = $syllabus->findPatternsInWord($allPatterns);
            }
    
            if ($wordImportSelection == Reader::ENTER_WORD_FROM_CLI
                && $importSelection == Reader::IMPORT_FROM_DATABASE
            ) {
                $word->setSyllabifiedWord($syllabifiedWord);
                $this->insertWordAndPatternsIntoDatabase(
                    $database,
                    $word,
                    $foundPatters
                );
            }
        }
    
    
        $timeStart = new DateTime();
    
    
        $diff = $timeStart->diff(new DateTime());
        $this->logger->info("Time taken to syllabify: $diff->f microseconds");
        
        $result = new Result(
            $word,
            $syllabifiedWord,
            $foundPatters,
            $diff
        );
        
        $output = new Output(new TerminalOutput($result));
        $output->output();
    }
    
    //todo move these to reader class?
    private function getAllPatterns(
        string $selection,
        Database $database
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
        $controller = new PatternController($this->logger, $database);
        $allPatterns = $controller->index();
        $this->logger->info("Read patterns from database");
        
        return $allPatterns;
    }
    
    private function readFromFile(): PatternCollection
    {
        $fileName = FileReaderInterface::DEFAULT_PATTERN_LINK;
        $reader = new Reader();
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
        $wordController->insert($foundPatters,$word);
    }
    
    private function checkIfWordWasSyllabified(
        WordController $wordController,
        Database $database,
        Word $word
    ): bool {
        $allWords = $wordController->index();
        
        foreach ($allWords as $wordFromDb) {
            if ($wordFromDb == $word) {
                echo "This word was already syllabified!\n";
                
                return true;
            }
        }
        
        return false;
    }
}