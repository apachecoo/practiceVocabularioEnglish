<?php

class Vocabulary
{
    protected static string $table = 'vocabulary';
    protected static PDO $pdo;

    public ?int $id;
    public int $idCategory;
    public string $name;
    public string $translation;

    
    public static function all(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM ' . self::$table);
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Vocabulary');
    }

    public static function find(int $id): ?Vocabulary
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM ' . self::$table . ' WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Vocabulary');
        return $stmt->fetch() ?: null;
    }

    public static function getVocabularyByIdCategory(int $idCategory, array $excludeIds = []): ?array
    {
        $pdo = Database::getConnection();
        
        $placeholders = implode(',', array_fill(0, count($excludeIds), '?'));
        $sql = 'SELECT * FROM ' . self::$table . ' WHERE idCategory = ?';
        $params = [$idCategory];
        if (!empty($excludeIds)) {
            $sql .= ' AND id NOT IN (' . $placeholders . ')';
            $params = array_merge($params, $excludeIds);
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

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
