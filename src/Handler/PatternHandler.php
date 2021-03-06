<?php

namespace Syllabus\Handler;

use Syllabus\Core\PatternCollection;
use Syllabus\Database\Database;
use Syllabus\Database\MySqlQueryBuilder;
use Syllabus\Model\Pattern;

class PatternHandler
{
    private Database $database;
    private const TABLE_NAME = "Pattern";

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function index(): PatternCollection
    {
        $patterns = new PatternCollection();
        $pdo = $this->database->connect();

        $sql = (new MySqlQueryBuilder())->select(["patternString"])->from(self::TABLE_NAME);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $pattern = new Pattern($row['patternString']);
            $patterns->add($pattern);
        }

        return $patterns;
    }

    public function insert(Pattern $pattern): void
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;

        $sql = "insert into $table (patternString) values (:patternString);";
        $patternString = filter_var($pattern->getPatterString());
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            [
                ':patternString' => $patternString
            ]
        );
    }

    public function isTableEmpty(): bool
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;

        $sql = (new MySqlQueryBuilder())->select(['*'])->from($table)->limit(1);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($stmt->fetch())) {
            return true;
        }

        return false;
    }

    public function getId(string $patternString)
    {
        $pdo = $this->database->connect();

        $sql = "SELECT id FROM Pattern where patternString = :patternString";

        $stmt = $pdo->prepare($sql);
        $patternString = filter_var($patternString, FILTER_SANITIZE_STRING);
        $stmt->execute(
            [
                ':patternString' => $patternString
            ]
        );
        $id = $stmt->fetch();
        return ($id['id']);
    }
}
