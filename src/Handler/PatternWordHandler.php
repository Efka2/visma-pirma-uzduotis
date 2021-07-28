<?php

namespace Syllabus\Handler;

use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollection;
use Syllabus\Database\Database;
use Syllabus\Model\Pattern;
use Syllabus\Model\Word;

class PatternWordHandler
{
    private const TABLE_NAME = "Pattern_Word";
    private Database $database;
    private PatternHandler $patternHandler;

    public function __construct(Database $database, PatternHandler $patternHandler)
    {
        $this->database = $database;
        $this->patternHandler = $patternHandler;
    }

    public function getPatterns($id): CollectionInterface
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;
        $patterns = new PatternCollection();

        $sql = "select patternString
                from Pattern
                inner join $table
                on patternID = Pattern.id
                where Pattern_Word.wordID = $id; ";
        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch()) {
            $pattern = new Pattern($row['patternString']);
            $patterns->add($pattern);
        }
        return $patterns;
    }

    public function getWordsAndPatters(): array
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;
        $array = [];

        $sql = "select distinct id, wordString, syllabifiedWord 
                from Pattern_Word
                inner join Word
                on wordID = Word.id;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $wordId = $row['id'];
            $wordString = $row['wordString'];
            $syllabifiedString = $row['syllabifiedWord'];

            $patternsCollection = $this->getPatterns($wordId);

            $patterns = [];
            foreach ($patternsCollection->getAll() as $pattern) {
                $patterns[] = $pattern->getPatterString();
            }

            $array[] = [
              'wordId' => $wordId,
              'wordString' => $wordString,
              'syllabifiedString' => $syllabifiedString,
                'patterns' => $patterns
            ];
        }
        return $array;
    }

    //todo
//    public function update(int $wordId, )
//    {
//
//    }

    public function insert(Word $word, CollectionInterface $patterns)
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;
        $wordString = $word->getWordString();
//        $syllabifiedWord = $word->getSyllabifiedWord();

        try {
            $pdo->beginTransaction();

//            $sqlInsertWord = "INSERT INTO Word
//                            (wordString, syllabifiedWord)
//                             VALUES (?, ?);";
//
//            $stmt = $pdo->prepare($sqlInsertWord);
//            $stmt->execute([$wordString, $syllabifiedWord]);
//
//            $stmt->closeCursor();

            $sqlSelectWordId = "SELECT id FROM Word WHERE wordString = ?;";
            $stmt = $pdo->prepare($sqlSelectWordId);
            $stmt->execute([$wordString]);
            $wordId = $stmt->fetch()[0];

            foreach ($patterns->getAll() as $pattern) {
                $patternId = $this->patternHandler->getId($pattern->getPatterString());

                $sqlInsertPatternWord = "INSERT INTO $table
                                (patternID, wordID)
                                VALUES (?, ?);";

                $stmt = $pdo->prepare($sqlInsertPatternWord);
                $stmt->execute([$patternId, $wordId]);
                $stmt->closeCursor();
            }

            $pdo->commit();
        } catch (\PDOException $exception) {
            $pdo->rollBack();
            die($exception->getMessage());
        }
    }
}
