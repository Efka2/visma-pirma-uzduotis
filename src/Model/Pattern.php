<?php

namespace Syllabus\Model;

use Syllabus\Database\Database;
use Syllabus\Service\SyllabusHelper;

class Pattern
{
    private int $id;
    private string $patternString;
    
    public function __construct(string $patternString)
    {
        $this->patternString = $patternString;
    }

    public function getPatterString(){
        return $this->patternString;
    }
    
    //todo trait?
    public function getPatterStringWithoutDots(): string
    {
        return str_replace('.', '', $this->patternString);
    }
    
    public function getPatternStringWithoutNumbers(): string
    {
        return str_replace(SyllabusHelper::NUMBERS, '', $this->patternString);
    }
    
    public function __toString(): string
    {
        return $this->patternString;
    }
    
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