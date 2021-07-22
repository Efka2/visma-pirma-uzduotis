<?php

namespace Syllabus\Model;

use Syllabus\Database\Database;
use Syllabus\Service\Syllabus;
use Syllabus\Service\SyllabusHelper;

class Pattern
{
    private int $id;
    private string $patternString;
    
    public function __construct(string $patternString)
    {
        $this->patternString = $patternString;
    }

    public function getPatterString(): string
    {
        return $this->patternString;
    }
    
    public function getPatternStringWithoutNumbers(): string
    {
        return str_replace(Syllabus::NUMBERS, '', $this->patternString);
    }
    
    public function __toString(): string
    {
        return $this->patternString;
    }

    //todo move
    public function getId()
    {
        $db = new Database();
        $pdo = $db->connect();
        $patternString = $this->patternString;
        
        $sql = "SELECT id FROM Pattern where patternString = '$patternString'";
        $id = $pdo->query($sql)->fetch();
        return ($id['id']);
    }
    
}