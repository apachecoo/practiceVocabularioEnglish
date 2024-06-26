<?php

class Category
{
    protected static string $table = 'category';
    protected static PDO $pdo;

    public $id;
    public $name;

    public $translation;

    public static function initialize(): void
    {
        self::$pdo = new PDO('mysql:host=mariadb;port=3306;dbname=vocabulary_english', 'user', '12345');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function all(): array
    {
        self::initialize();
        $stmt = self::$pdo->query('SELECT * FROM ' . self::$table);
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    }


    public static function find(int $id): EmployeeModel|bool|null
    {
        self::initialize();
        try {
            $stmt = self::$pdo->prepare('SELECT * FROM ' . self::$table . ' WHERE id = :id');
            $stmt->execute(array(':id' => $id));
            if ($stmt->rowCount() === 0) {
                return null;
            }
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }
}
