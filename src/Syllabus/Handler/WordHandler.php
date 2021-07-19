<?php

namespace Syllabus\Handler;

use Syllabus\Database\Database;
use Syllabus\Model\Word;

class WordHandler
{
    private const  TABLE_NAME = "Word";

    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAll(): array
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;
        $array = [];

        $sql = "SELECT * FROM $table;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $data = [
                'id' => $row['id'],
                'word' => $row['wordString'],
                'syllabifiedWord' => $row['syllabifiedWord']
            ];
            array_push($array, $data);

        }
        return $array;
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

    public function delete($id)
    {
        $pdo = $this->database->connect();
        try {
            $sql = "start transaction;

                delete from Pattern_Word
                Where wordID = $id;
                
                delete from Word
                Where id = $id;
                
                commit;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

        } catch (\PDOException $exception) {
            //todo replace die() with exception
            echo $exception->errorInfo;
            die();
        }
    }
}