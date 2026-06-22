<?php
namespace App\Repositories;

use App\Core\Database;
use PDO;

/**
 * Base Repository - Repository Pattern
 * 
 * Class cha cho tất cả repositories
 * Cung cấp các phương thức CRUD cơ bản
 * 
 * Design Pattern: Repository Pattern
 * 
 * @author Lê Văn Thuận (22070984)
 */
abstract class BaseRepository
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Find record by ID
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find all records
     */
    public function findAll(array $conditions = [], string $orderBy = '', int $limit = 0, int $offset = 0): array
    {
        $sql = "SELECT * FROM `{$this->table}`";
        $params = [];
        
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                if ($value !== null) {
                    $where[] = "`$key` = :$key";
                    $params[$key] = $value;
                }
            }
            if (!empty($where)) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }
        }
        
        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }
        
        if ($limit > 0) {
            $sql .= " LIMIT $limit";
            if ($offset > 0) {
                $sql .= " OFFSET $offset";
            }
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }

    /**
     * Find one record by conditions
     */
    public function findOne(array $conditions): ?array
    {
        $results = $this->findAll($conditions, '', 1);
        return $results[0] ?? null;
    }

    /**
     * Create new record
     */
    public function create(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":$col", $columns);
        
        $columnNames = array_map(fn($col) => "`$col`", $columns);
        
        $sql = sprintf(
            "INSERT INTO `%s` (%s) VALUES (%s)",
            $this->table,
            implode(', ', $columnNames),
            implode(', ', $placeholders)
        );
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        
        return (int) $this->db->lastInsertId();
    }

    /**
     * Update record by ID
     */
    public function update(int $id, array $data): bool
    {
        $sets = [];
        foreach ($data as $key => $value) {
            $sets[] = "`$key` = :$key";
        }
        
        $sql = sprintf(
            "UPDATE `%s` SET %s WHERE `%s` = :id",
            $this->table,
            implode(', ', $sets),
            $this->primaryKey
        );
        
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($data);
    }

    /**
     * Delete record by ID
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Count records
     */
    public function count(array $conditions = []): int
    {
        $sql = "SELECT COUNT(*) as total FROM `{$this->table}`";
        $params = [];
        
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                if ($value !== null) {
                    $where[] = "`$key` = :$key";
                    $params[$key] = $value;
                }
            }
            if (!empty($where)) {
                $sql .= " WHERE " . implode(' AND ', $where);
            }
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    /**
     * Check if record exists
     */
    public function exists(array $conditions): bool
    {
        return $this->count($conditions) > 0;
    }

    /**
     * Execute raw SQL query
     */
    protected function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Execute raw SQL command (INSERT, UPDATE, DELETE)
     */
    protected function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}
