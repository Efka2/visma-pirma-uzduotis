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

    public function getById(int $id): ?Word
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;

        $sql = "SELECT * FROM $table WHERE id = :id";
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            [
                ':id' => $id
            ]
        );
        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        $newWord = new Word($data['wordString']);
        $newWord->setSyllabifiedWord($data['syllabifiedWord']);

        return $newWord;
    }

    public function getByString(string $word): ?Word
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;

        $sql = "SELECT * FROM $table WHERE wordString = :wordString";
        $wordString = filter_var($word, FILTER_SANITIZE_STRING);
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            [
                ':wordString' => $wordString
            ]
        );
        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        $newWord = new Word($data['wordString']);
        $newWord->setSyllabifiedWord($data['syllabifiedWord']);

        return $newWord;
    }

    public function getWordId(string $word): ?int
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;

        $sql = "SELECT id FROM $table WHERE wordString = :wordString;";
        $wordString = filter_var($word, FILTER_SANITIZE_STRING);
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            [
                ':wordString' => $wordString
            ]
        );
        $data = $stmt->fetch();

        if (!$data[0]) {
            return null;
        }

        return $data[0];
    }

    public function update(Word $word, array $params): void
    {
        $table = self::TABLE_NAME;
        $pdo = $this->database->connect();

        $sql = "UPDATE $table 
                    SET 
                    wordString = :wordString,
                    syllabifiedWord = :syllabifiedWord
                    WHERE
                    wordString = :currentWordString ;";

        $varriables = filter_var_array(
            [
                'wordString' => $params['wordString'],
                'syllabifiedWord' => $params['syllabifiedWord'],
                'currentWordString' => $word->getWordString()
            ],
            FILTER_SANITIZE_STRING
        );

        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            [
                ':wordString' => $varriables['wordString'],
                ':syllabifiedWord' => $varriables['syllabifiedWord'],
                ':currentWordString' => $varriables['currentWordString'],
            ]
        );
    }

    public function insert(Word $word): void
    {
        $table = self::TABLE_NAME;
        $pdo = $this->database->connect();
        $wordString = $word->getWordString();
        $syllabifiedWord = $word->getSyllabifiedWord();

        $sql = "INSERT INTO $table (wordString, syllabifiedWord) VALUES (:wordString, :syllabifiedWord);";
        $stmt = $pdo->prepare($sql);
        $wordString = filter_var($wordString, FILTER_SANITIZE_STRING);
        $syllabifiedWord = filter_var($syllabifiedWord, FILTER_SANITIZE_STRING);
        $stmt->execute(
            [
                ':wordString' => $wordString,
                ':syllabifiedWord' => $syllabifiedWord
            ]
        );
    }

    public function isWordInDatabase(string $word): bool
    {
        $wordFromDb = $this->getByString($word);
        if ($wordFromDb) {
            return true;
        }

        return false;
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
                Where wordID = :id;
                
                delete from Word
                Where wordString = :wordString;
                
                commit;";

            $stmt = $pdo->prepare($sql);
            $id = filter_var($id, FILTER_VALIDATE_INT);
            $wordString = filter_var($word, FILTER_SANITIZE_STRING);
            $stmt->execute(
                [
                    ':id' => $id,
                    ':wordString' => $wordString
                ]
            );

            return 0;
        } catch (\PDOException $exception) {
            //todo replace die() with exception
            echo $exception->errorInfo;
            die();
        }
    }
}
