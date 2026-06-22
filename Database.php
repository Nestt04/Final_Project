<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Database Class - Singleton Pattern
 * 
 * Quản lý kết nối database duy nhất trong toàn bộ application
 * Design Pattern: Singleton
 * 
 * @author Lê Văn Thuận (22070984)
 */
class Database
{
    private static ?Database $instance = null;
    private ?PDO $connection = null;

    /**
     * Private constructor để ngăn khởi tạo trực tiếp
     */
    private function __construct()
    {
        try {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                DB_HOST,
                DB_NAME,
                DB_CHARSET
            );

            $this->connection = new PDO($dsn, DB_USER, DB_PASS, DB_OPTIONS);
        } catch (PDOException $e) {
            die('Database Connection Failed: ' . $e->getMessage());
        }
    }

    /**
     * Ngăn clone instance
     */
    private function __clone() {}

    /**
     * Ngăn unserialize instance
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    /**
     * Lấy instance duy nhất của Database (Singleton)
     * 
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Lấy PDO connection
     * 
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Begin transaction
     */
    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollBack(): bool
    {
        return $this->connection->rollBack();
    }

    /**
     * Get last insert ID
     */
    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}
