<?php

namespace Syllabus\Handler;

use Syllabus\Core\PatternCollection;
use Syllabus\Database\Database;
use Syllabus\Model\Pattern;

class PatternHandler
{
    private Database $database;
    private string $table = "Pattern";
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    public function index(): PatternCollection
    {
        $patterns = new PatternCollection();
        
        $pdo = $this->database->connect();
        $sql = "select patternString from $this->table;";
        $stmt = $pdo->query($sql);
        
        while ($row = $stmt->fetch()) {
            $pattern = new Pattern($row['patternString']);
            $patterns->add($pattern);
        }
        
        return $patterns;
    }
    
    public function insert(Pattern $pattern): void
    {
        $pdo = $this->database->connect();
        $sql = "insert into $this->table (patternString) values (?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pattern]);
    }
    
    public function isTableEmpty(): bool
    {
        $pdo = $this->database->connect();
        $sql = "select * from $this->table limit 1;";
        $stmt = $pdo->query($sql);
        
        if (empty($stmt->fetch())) {
            return true;
        }
        
        return false;
    }
}