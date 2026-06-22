<?php
namespace App\Repositories;

class UserRepository extends BaseRepository {
    
    // Đã sửa thành $table (bỏ chữ s thừa) và nằm ở vị trí chuẩn của class
    protected string $table = 'users';

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->findOne(['email' => $email]);
    }

    /**
     * Find user by student code
     */
    public function findByStudentCode(string $studentCode): ?array
    {
        return $this->findOne(['student_code' => $studentCode]);
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as total FROM `{$this->table}` WHERE `email` = :email";
        
        $params = ['email' => $email];
        
        if ($excludeId) {
            $sql .= " AND `id` != :exclude_id";
            $params['exclude_id'] = $excludeId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        
        return $result['total'] > 0;
    }

    /**
     * Get users by role
     */
    public function findByRole(string $role): array
    {
        return $this->findAll(['role' => $role, 'is_active' => 1], 'full_name ASC');
    }

    /**
     * Get all students
     */
    public function findAllStudents(): array
    {
        return $this->findByRole('student');
    }

    /**
     * Get all lecturers
     */
    public function findAllLecturers(): array
    {
        return $this->findByRole('lecturer');
    }

    /**
     * Create user with hashed password
     */
    public function createUser(array $data): int
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, [
                'cost' => 10
            ]);
        }
        
        return $this->create($data);
    }

    /**
     * Update user password
     */
    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, [
            'cost' => 10
        ]);
        
        return $this->update($userId, ['password' => $hashedPassword]);
    }

    /**
     * Verify user password
     */
    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        
        if (!$user || !$user['is_active']) {
            return null;
        }
        
        if (password_verify($password, $user['password'])) {
            return $user;
        }
        
        return null;
    }

    /**
     * Activate/Deactivate user
     */
    public function setActive(int $userId, bool $isActive): bool
    {
        return $this->update($userId, ['is_active' => $isActive ? 1 : 0]);
    }

    /**
     * Search users
     */
    public function search(string $keyword, ?string $role = null): array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE 
                (`full_name` LIKE :keyword OR `email` LIKE :keyword OR `student_code` LIKE :keyword)";
        
        $params = ['keyword' => "%$keyword%"];
        
        if ($role) {
            $sql .= " AND `role` = :role";
            $params['role'] = $role;
        }
        
        $sql .= " ORDER BY `full_name` ASC";
        
        return $this->query($sql, $params);
    }

    /**
     * Get user statistics
     */
    public function getStatistics(): array
    {
        $sql = "SELECT 
                    `role`,
                    COUNT(*) as total,
                    SUM(CASE WHEN `is_active` = 1 THEN 1 ELSE 0 END) as active
                FROM `{$this->table}`
                GROUP BY `role`";
        
        return $this->query($sql);
    }
}