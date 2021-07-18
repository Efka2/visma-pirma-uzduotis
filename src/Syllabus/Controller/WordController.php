<?php

namespace Syllabus\Controller;

use Syllabus\Database\Database;
use Syllabus\Model\Word;

class WordController
{
    private static string $table = "Word";
    
    private Database $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    
    
    public function get(Word $word): Word
    {
        $pdo = $this->database->connect();
        $table = self::$table;
        
        $sql = "SELECT * FROM $table WHERE wordString = '$word'";
        $stmt = $pdo->query($sql);
        $a = $stmt->fetch();
        
        $newWord = new Word();
        $newWord->setSyllabifiedWord($a['syllabifiedWord']);
        $newWord->setWordString($a['wordString']);
        
        return $newWord;
    }
    
    public function insert(Word $word): void
    {
        $table = self::$table;
        $pdo = $this->database->connect();
        $wordString = $word->getWordString();
        $syllabifiedWord = $word->getSyllabifiedWord();
        
        $sql = "INSERT INTO $table (wordString, syllabifiedWord) VALUES (?, ?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$wordString, $syllabifiedWord]);
    }
}