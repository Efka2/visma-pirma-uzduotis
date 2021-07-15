<?php

namespace Syllabus\Model;

use Syllabus\Database\Database;

class Word
{
    private int $id;
    private string $wordString;
    private string $syllabifiedWord;
    
    public function getId(): int
    {
        $db = new Database();
        $pdo = $db->connect();
        $patternString = $this->wordString;
        
        $sql = "SELECT id FROM Word where wordString = '$patternString'";
        $id = $pdo->query($sql)->fetch();
        
        return ($id['id']);
    }
    
    public function getSyllabifiedWord(): string
    {
        return $this->syllabifiedWord;
    }
    
    public function getWordString(): string
    {
        return $this->wordString;
    }
    
    public function setSyllabifiedWord(string $syllabifiedWord): void
    {
        $this->syllabifiedWord = $syllabifiedWord;
    }
    
    public function setWordString(string $wordString): void
    {
        $this->wordString = $wordString;
    }
    
    public function __toString()
    {
        return $this->wordString;
    }
}