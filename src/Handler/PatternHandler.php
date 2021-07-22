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
        $table = self::TABLE_NAME;

        $sql = "insert into $table (patternString) values (?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pattern]);
    }

    public function isTableEmpty(): bool
    {
        $pdo = $this->database->connect();
        $table = self::TABLE_NAME;

        $sql = (new MySqlQueryBuilder())->select(['*'])->from($table)->limit(1);
        $stmt = $pdo->query($sql);

        if (empty($stmt->fetch())) {
            return TRUE;
        }

        return FALSE;
    }
}