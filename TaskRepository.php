<?php
namespace App\Repositories;

class TaskRepository extends BaseRepository
{
    protected string $table = 'tasks';

    /**
     * Get tasks by user (through assignments)
     */
    public function getTasksByUser(int $userId): array
    {
        $sql = "SELECT t.*, us.title as story_title, us.status as story_status,
                       ta.status as assignment_status, ta.assigned_at,
                       s.sprint_name, s.sprint_number
                FROM `{$this->table}` t
                JOIN `task_assignments` ta ON t.id = ta.task_id
                JOIN `user_stories` us ON t.user_story_id = us.id
                LEFT JOIN `sprints` s ON us.sprint_id = s.id
                WHERE ta.user_id = :user_id
                ORDER BY t.created_at DESC";
        
        return $this->query($sql, ['user_id' => $userId]);
    }

    /**
     * Get tasks by user and status
     */
    public function getTasksByUserAndStatus(int $userId, string $status): array
    {
        $sql = "SELECT t.*, us.title as story_title, us.status as story_status,
                       ta.status as assignment_status, ta.assigned_at,
                       s.sprint_name, s.sprint_number
                FROM `{$this->table}` t
                JOIN `task_assignments` ta ON t.id = ta.task_id
                JOIN `user_stories` us ON t.user_story_id = us.id
                LEFT JOIN `sprints` s ON us.sprint_id = s.id
                WHERE ta.user_id = :user_id AND t.status = :status
                ORDER BY t.priority DESC, t.created_at DESC";
        
        return $this->query($sql, ['user_id' => $userId, 'status' => $status]);
    }

    /**
     * Get task with full details
     */
    public function getTaskWithDetails(int $taskId): ?array
    {
        $sql = "SELECT t.*, 
                       us.title as story_title, us.description as story_description,
                       s.sprint_name, s.sprint_number, s.start_date, s.end_date,
                       ta.assigned_by, ta.assigned_at, ta.notes,
                       u.full_name as assignee_name, u.email as assignee_email,
                       creator.full_name as assigner_name
                FROM `{$this->table}` t
                JOIN `user_stories` us ON t.user_story_id = us.id
                LEFT JOIN `sprints` s ON us.sprint_id = s.id
                JOIN `task_assignments` ta ON t.id = ta.task_id
                JOIN `users` u ON ta.user_id = u.id
                JOIN `users` creator ON ta.assigned_by = creator.id
                WHERE t.id = :task_id
                LIMIT 1";
        
        $result = $this->query($sql, ['task_id' => $taskId]);
        return $result[0] ?? null;
    }

    /**
     * Update task status
     */
    public function updateStatus(int $taskId, string $status): bool
    {
        return $this->update($taskId, ['status' => $status]);
    }

    /**
     * Update actual hours
     */
    public function updateActualHours(int $taskId, float $hours): bool
    {
        return $this->update($taskId, ['actual_hours' => $hours]);
    }

    /**
     * Search tasks
     */
    public function searchTasks(int $userId, string $keyword): array
    {
        $sql = "SELECT t.*, us.title as story_title, s.sprint_name
                FROM `{$this->table}` t
                JOIN `task_assignments` ta ON t.id = ta.task_id
                JOIN `user_stories` us ON t.user_story_id = us.id
                LEFT JOIN `sprints` s ON us.sprint_id = s.id
                WHERE ta.user_id = :user_id 
                AND (t.title LIKE :keyword OR t.description LIKE :keyword)
                ORDER BY t.created_at DESC";
        
        return $this->query($sql, [
            'user_id' => $userId,
            'keyword' => "%$keyword%"
        ]);
    }
}
