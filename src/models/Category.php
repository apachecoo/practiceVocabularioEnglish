<?php


class Category
{
    protected static string $table = 'category';

    public ?int $id = null;
    public string $name;
    public ?string $translation = null;


    public static function all(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM ' . self::$table);
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
    }


    public static function find(int $id): Category|bool|null
    {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare('SELECT * FROM ' . self::$table . ' WHERE id = :id');
            $stmt->execute([':id' => $id]);
            if ($stmt->rowCount() === 0) {
                return null;
            }
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Category');
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            echo 'Error al ejecutar la consulta del método ' . __FUNCTION__ . ': ' . $e->getMessage();
            return false;
        }
    }
}
