<?php
use App\Core\Session;
use App\Controllers\AuthController;

AuthController::requireAuth();

// Get task ID from URL
$taskId = $_GET['id'] ?? 0;

// Mock data for now - will be replaced with database
$task = [
    'id' => $taskId,
    'title' => 'Create course form UI',
    'description' => 'Design and implement course creation form with validation. Include all necessary fields and error handling.',
    'status' => 'in_progress',
    'priority' => 'high',
    'estimated_hours' => 4.0,
    'actual_hours' => 2.5,
    'created_at' => '2026-02-15 10:00:00',
    'story_title' => 'Course management CRUD',
    'sprint_name' => 'Sprint 2 - Core Features',
    'assignee_name' => Session::getUserFullName(),
    'assigner_name' => 'Lê Văn Thuận',
    'deadline' => '2026-02-28'
];

$userName = Session::getUserFullName();
$userRole = Session::getUserRole();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task #<?php echo $task['id']; ?> | <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <style>
        .task-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .comment-box {
            background: #89accfff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .time-tracker {
            background: #90b5cfff;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #2196f3;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-graduation-cap me-2"></i><?php echo APP_NAME; ?>
            </a>
            <div class="ms-auto">
                <a href="<?php echo BASE_URL; ?>tasks" class="btn btn-light btn-sm me-2">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại Tasks
                </a>
                <a href="<?php echo BASE_URL . $userRole; ?>/dashboard" class="btn btn-outline-light btn-sm">
                    Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Task Header -->
        <div class="task-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="text-white-50 mb-2">
                        <i class="fas fa-layer-group me-2"></i><?php echo htmlspecialchars($task['story_title']); ?>
                    </h6>
                    <h2 class="mb-3"><?php echo htmlspecialchars($task['title']); ?></h2>
                    <div class="d-flex gap-2">
                        <span class="badge bg-<?php echo $task['status'] === 'done' ? 'success' : ($task['status'] === 'in_progress' ? 'warning' : 'secondary'); ?> fs-6">
                            <?php echo strtoupper(str_replace('_', ' ', $task['status'])); ?>
                        </span>
                        <span class="badge bg-<?php echo $task['priority'] === 'high' ? 'danger' : ($task['priority'] === 'medium' ? 'warning' : 'info'); ?> fs-6">
                            <?php echo strtoupper($task['priority']); ?> PRIORITY
                        </span>
                    </div>
                </div>
                <div class="text-end">
                    <h1 class="display-4 mb-0">#<?php echo $task['id']; ?></h1>
                    <small>Task ID</small>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Description -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-align-left me-2"></i>Mô tả</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                    </div>
                </div>

                <!-- Status Actions -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Cập nhật trạng thái</h5>
                    </div>
                    <div class="card-body">
                        <div class="btn-group w-100" role="group">
                            <button type="button" class="btn btn-outline-secondary <?php echo $task['status'] === 'todo' ? 'active' : ''; ?>">
                                <i class="fas fa-inbox me-2"></i>TODO
                            </button>
                            <button type="button" class="btn btn-outline-warning <?php echo $task['status'] === 'in_progress' ? 'active' : ''; ?>">
                                <i class="fas fa-spinner me-2"></i>IN PROGRESS
                            </button>
                            <button type="button" class="btn btn-outline-info <?php echo $task['status'] === 'review' ? 'active' : ''; ?>">
                                <i class="fas fa-eye me-2"></i>REVIEW
                            </button>
                            <button type="button" class="btn btn-outline-success <?php echo $task['status'] === 'done' ? 'active' : ''; ?>">
                                <i class="fas fa-check me-2"></i>DONE
                            </button>
                        </div>
                        <div class="alert alert-info mt-3 mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Click vào trạng thái mới để cập nhật
                        </div>
                    </div>
                </div>

                <!-- Time Tracking -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Theo dõi thời gian</h5>
                    </div>
                    <div class="card-body">
                        <div class="time-tracker">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <h3 class="text-primary"><?php echo $task['estimated_hours']; ?>h</h3>
                                    <p class="text-muted mb-0">Ước lượng</p>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="text-warning"><?php echo $task['actual_hours']; ?>h</h3>
                                    <p class="text-muted mb-0">Đã làm</p>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="text-<?php echo ($task['estimated_hours'] - $task['actual_hours']) >= 0 ? 'success' : 'danger'; ?>">
                                        <?php echo abs($task['estimated_hours'] - $task['actual_hours']); ?>h
                                    </h3>
                                    <p class="text-muted mb-0">
                                        <?php echo ($task['estimated_hours'] - $task['actual_hours']) >= 0 ? 'Còn lại' : 'Vượt quá'; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 25px;">
                                <?php 
                                $progress = ($task['actual_hours'] / $task['estimated_hours']) * 100;
                                $progressClass = $progress > 100 ? 'bg-danger' : ($progress > 75 ? 'bg-warning' : 'bg-success');
                                ?>
                                <div class="progress-bar <?php echo $progressClass; ?>" style="width: <?php echo min($progress, 100); ?>%">
                                    <?php echo round($progress, 1); ?>%
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <form class="row g-2">
                                <div class="col-md-8">
                                    <input type="number" class="form-control" step="0.5" placeholder="Thêm giờ làm việc (vd: 2.5)">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-info text-white w-100">
                                        <i class="fas fa-plus me-2"></i>Cập nhật
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Comments -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Comments (3)</h5>
                    </div>
                    <div class="card-body">
                        <!-- Comment 1 -->
                        <div class="comment-box">
                            <div class="d-flex justify-content-between mb-2">
                                <strong><i class="fas fa-user-circle me-2 text-primary"></i>Lê Văn Thuận</strong>
                                <small class="text-muted">2 giờ trước</small>
                            </div>
                            <p class="mb-0">Nhớ validate tất cả các trường input, email phải check format @vnu.edu.vn</p>
                        </div>

                        <!-- Comment 2 -->
                        <div class="comment-box">
                            <div class="d-flex justify-content-between mb-2">
                                <strong><i class="fas fa-user-circle me-2 text-success"></i><?php echo htmlspecialchars($userName); ?></strong>
                                <small class="text-muted">1 giờ trước</small>
                            </div>
                            <p class="mb-0">Ok, đã làm validation rồi. Đang test các trường hợp</p>
                        </div>

                        <!-- Comment 3 -->
                        <div class="comment-box">
                            <div class="d-flex justify-content-between mb-2">
                                <strong><i class="fas fa-user-circle me-2 text-info"></i>Bùi Minh Hiếu</strong>
                                <small class="text-muted">30 phút trước</small>
                            </div>
                            <p class="mb-0">Có cần thêm CAPTCHA không? Để tránh spam</p>
                        </div>

                        <!-- Add Comment Form -->
                        <div class="mt-3">
                            <form>
                                <div class="mb-2">
                                    <textarea class="form-control" rows="3" placeholder="Viết comment..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Gửi comment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Task Info -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-label"><i class="fas fa-user me-2"></i>Người được giao</div>
                        <div class="info-value"><?php echo htmlspecialchars($task['assignee_name']); ?></div>

                        <div class="info-label"><i class="fas fa-user-tie me-2"></i>Người giao việc</div>
                        <div class="info-value"><?php echo htmlspecialchars($task['assigner_name']); ?></div>

                        <div class="info-label"><i class="fas fa-layer-group me-2"></i>User Story</div>
                        <div class="info-value">
                            <a href="#" class="text-decoration-none"><?php echo htmlspecialchars($task['story_title']); ?></a>
                        </div>

                        <div class="info-label"><i class="fas fa-calendar-alt me-2"></i>Sprint</div>
                        <div class="info-value"><?php echo htmlspecialchars($task['sprint_name']); ?></div>

                        <div class="info-label"><i class="fas fa-calendar-check me-2"></i>Deadline</div>
                        <div class="info-value text-danger">
                            <strong><?php echo date('d/m/Y', strtotime($task['deadline'])); ?></strong>
                            <br><small>Còn 6 ngày</small>
                        </div>

                        <div class="info-label"><i class="fas fa-calendar-plus me-2"></i>Ngày tạo</div>
                        <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($task['created_at'])); ?></div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Thao tác nhanh</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success w-100 mb-2">
                            <i class="fas fa-check me-2"></i>Đánh dấu hoàn thành
                        </button>
                        <button class="btn btn-warning w-100 mb-2">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa task
                        </button>
                        <button class="btn btn-info w-100 mb-2 text-white">
                            <i class="fas fa-share me-2"></i>Chia sẻ
                        </button>
                        <button class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>Xóa task
                        </button>
                    </div>
                </div>

                <!-- Activity -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Lịch sử</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">2 giờ trước</small>
                            <p class="mb-0"><strong>Bạn</strong> đã chuyển từ TODO sang IN PROGRESS</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">5 giờ trước</small>
                            <p class="mb-0"><strong>Bạn</strong> đã giao task cho Lê Văn Thuận</p>
                        </div>
                        <div>
                            <small class="text-muted">1 ngày trước</small>
                            <p class="mb-0"><strong>Bạn</strong> đã tạo task </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Status update buttons
        document.querySelectorAll('.btn-group button').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Bạn muốn cập nhật trạng thái này?')) {
                    // Remove active from all
                    document.querySelectorAll('.btn-group button').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    // Add active to clicked
                    this.classList.add('active');
                    // Show success message
                    alert('✅ Cập nhật trạng thái thành công!');
                }
            });
        });
    </script>