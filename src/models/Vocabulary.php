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
        if (!isset(self::$pdo)) {
            self::$pdo = new PDO('mysql:host=mariadb;port=3306;dbname=vocabulary_english', 'user', '12345');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function all(): array
    {
        self::initialize();
        $stmt = self::$pdo->query('SELECT * FROM ' . self::$table);
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Vocabulary');
    }

    public static function find(int $id): ?Vocabulary
    {
        self::initialize();
        $stmt = self::$pdo->prepare('SELECT * FROM ' . self::$table . ' WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Vocabulary');
        return $stmt->fetch() ?: null;
    }

    public static function getVocabularyByIdCategory(int $idCategory, array $excludeIds = []): ?array
    {
        self::initialize();
        
        // Construir los marcadores de posición para los IDs a excluir
        $placeholders = implode(',', array_fill(0, count($excludeIds), '?'));

        // Construir la consulta SQL
        $sql = 'SELECT * FROM ' . self::$table . ' WHERE idCategory = ?';
        $params = [$idCategory];

        if (!empty($excludeIds)) {
            $sql .= ' AND id NOT IN (' . $placeholders . ')';
            $params = array_merge($params, $excludeIds);
        }

        // Preparar la consulta
        $stmt = self::$pdo->prepare($sql);

        // Ejecutar la consulta con los parámetros directamente
        $stmt->execute($params);

        // Devolver los resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }
    
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'idCategory' => $this->idCategory,
            'name' => $this->name,
            'translation' => $this->translation,
        ];
    }
}
