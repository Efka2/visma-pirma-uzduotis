<?php

namespace Syllabus\Handler;

use Syllabus\Database\Database;
use Syllabus\Database\MySqlQueryBuilder;
use Syllabus\Model\Word;

class WordHandler
{
    private const TABLE_NAME = "Word";
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

        $sql = (new MySqlQueryBuilder())->select(['*'])->from($table);
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

    public function get(string $word): ?Word
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;

        $sql = "SELECT * FROM $table WHERE wordString = '$word'";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetch();

        if (!$data) {
            return NULL;
        }

        $newWord = new Word();
        $newWord->setSyllabifiedWord($data['syllabifiedWord']);
        $newWord->setWordString($data['wordString']);

        return $newWord;
    }

    public function getWordId(string $word): ?int
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;

        $sql = "SELECT id FROM $table WHERE wordString = '$word';";
        $stmt = $pdo->query($sql);
        $data = $stmt->fetch();

        if (!$data[0]) {
            return NULL;
        }

        return $data[0];
    }

    public function update(Word $word, array $params): void
    {
        $table = self::TABLE_NAME;
        $pdo = $this->database->connect();
        $currentWordString = $word->getWordString();
        $replaceWordString = $params['wordString'];
        $replaceSyllabifiedWord = $params['syllabifiedWord'];

        $sql = "UPDATE $table 
                SET 
                    wordString = '$replaceWordString',
                    syllabifiedWord = '$replaceSyllabifiedWord'
                WHERE
                    wordString = '$currentWordString';";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function insert(Word $word): void
    {
        $table = self::TABLE_NAME;
        $pdo = $this->database->connect();
        $wordString = $word->getWordString();
        $syllabifiedWord = $word->getSyllabifiedWord();

        $sql = "INSERT INTO $table (wordString, syllabifiedWord) VALUES (?, ?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$wordString, $syllabifiedWord]);
    }

    public function isWordInDatabase(string $word): bool
    {
        $wordFromDb = $this->get($word);
        if ($wordFromDb) {
            return TRUE;
        }

        return FALSE;
    }

    public function delete(string $word): int
    {
        $pdo = $this->database->connect();
        $id = $this->getWordId($word);
        if (!$id) {
            return -1;
        }
        try {
            $sql = "start transaction;
                   
                delete from Pattern_Word
                Where wordID = $id;
                
                delete from Word
                Where wordString = '$word';
                
                commit;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return 0;
        } catch (\PDOException $exception) {
            //todo replace die() with exception
            echo $exception->errorInfo;
            die();
        }
    }
}