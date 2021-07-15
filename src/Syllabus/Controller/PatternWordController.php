<?php

namespace Syllabus\Controller;

use Syllabus\Database\Database;
use Syllabus\Model\Pattern;
use Syllabus\Model\Word;

class PatternWordController
{
    private Database $database;
    private static string $table = "Pattern_Word";
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    public function insert(Pattern $pattern, Word $word){
        $pdo = $this->database->connect();
        $table = self::$table;
        $patternId = $pattern->getId();
        $wordId = $word->getId();
        
        $sql = "INSERT INTO $table (patternID, wordID) VALUES (?,?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$patternId, $wordId]);
    }
}