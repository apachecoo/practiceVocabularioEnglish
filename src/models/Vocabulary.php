<?php

class Vocabulary
{
    protected static string $table = 'vocabulary';
    protected static PDO $pdo;

    public $id;
    public $idCategory;
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
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Vocabulary');
    }


    public static function find(int $id): Vocabulary|bool|null
    {
        self::initialize();
        try {
            $stmt = self::$pdo->prepare('SELECT * FROM ' . self::$table . ' WHERE id = :id');
            $stmt->execute(array(':id' => $id));
            if ($stmt->rowCount() === 0) {
                return null;
            }
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Vocabulary');
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }

    public function getVocabularyByIdCategory(int $idCategory) {
        self::initialize();
        try {
            $statement = self::$pdo->prepare('SELECT * FROM ' . self::$table . ' WHERE idCategory = :idCategory');
            $statement->execute(array(':idCategory' => $idCategory));
            if ($statement->rowCount() === 0) {
                return null;
            }
            
            return $statement->fetchAll(PDO::FETCH_ASSOC) ?: null;
            
            
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }
}
