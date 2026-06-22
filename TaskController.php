<?php
namespace App\Controllers;

use App\Core\Session;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;

class TaskController
{
    private TaskRepository $taskRepo;
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->taskRepo = new TaskRepository();
        $this->userRepo = new UserRepository();
    }

    /**
     * Get all tasks for current user
     */
    public function getMyTasks(): array
    {
        $userId = Session::getUserId();
        return $this->taskRepo->getTasksByUser($userId);
    }

    /**
     * Get tasks by status
     */
    public function getTasksByStatus(string $status): array
    {
        $userId = Session::getUserId();
        return $this->taskRepo->getTasksByUserAndStatus($userId, $status);
    }

    /**
     * Get task statistics
     */
    public function getStatistics(): array
    {
        $userId = Session::getUserId();
        
        $todo = count($this->taskRepo->getTasksByUserAndStatus($userId, 'todo'));
        $inProgress = count($this->taskRepo->getTasksByUserAndStatus($userId, 'in_progress'));
        $review = count($this->taskRepo->getTasksByUserAndStatus($userId, 'review'));
        $done = count($this->taskRepo->getTasksByUserAndStatus($userId, 'done'));
        
        $total = $todo + $inProgress + $review + $done;
        $completion = $total > 0 ? round(($done / $total) * 100, 1) : 0;
        
        return [
            'todo' => $todo,
            'in_progress' => $inProgress,
            'review' => $review,
            'done' => $done,
            'total' => $total,
            'completion_rate' => $completion
        ];
    }

    /**
     * Update task status
     */
    public function updateStatus(int $taskId, string $newStatus): bool
    {
        // Validate status
        $validStatuses = ['todo', 'in_progress', 'review', 'done'];
        if (!in_array($newStatus, $validStatuses)) {
            Session::flash('error', 'Trạng thái không hợp lệ');
            return false;
        }

        $result = $this->taskRepo->updateStatus($taskId, $newStatus);
        
        if ($result) {
            Session::flash('success', 'Cập nhật trạng thái thành công');
            return true;
        }
        
        Session::flash('error', 'Cập nhật thất bại');
        return false;
    }

    /**
     * Get task detail
     */
    public function getTaskDetail(int $taskId): ?array
    {
        return $this->taskRepo->getTaskWithDetails($taskId);
    }
}
