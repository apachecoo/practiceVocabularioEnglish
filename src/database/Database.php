<?php


class Database
{

    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO('mysql:host=mariadb;port=3306;dbname=vocabulary_english', 'user', '12345');
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Error al conectar a la base de datos' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
