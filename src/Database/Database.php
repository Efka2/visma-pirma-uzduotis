<?php

namespace Syllabus\Database;

use PDO;
use PDOException;

class Database
{
    private string $user = "root";
    private string $host = "localhost";
    private string $password = "password";
    private string $database = "syllabus";
    private string $charset = "utf8mb4";
    
    public function connect(): PDO
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset;";
    
            $pdo = new PDO(
                $dsn,
                $this->user,
                $this->password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: ". $e->getMessage();
        }
        return $pdo;
    }
}