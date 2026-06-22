<?php
use App\Core\Session;
use App\Controllers\AuthController;

AuthController::requireAuth();

$userName = Session::getUserFullName();
$userRole = Session::getUserRole();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dự án của tôi | <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-graduation-cap me-2"></i><?php echo APP_NAME; ?>
            </a>
            <div class="ms-auto">
                <a href="<?php echo BASE_URL . $userRole; ?>/dashboard" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h2 class="mb-4"><i class="fas fa-project-diagram me-2"></i>Dự án của tôi</h2>

        <!-- Project Card -->
        <div class="card mb-4 shadow">
            <div class="card-header bg-primary text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-0">
                            <i class="fas fa-folder-open me-2"></i>Team Alpha - PBL Tracker System
                        </h4>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge bg-success fs-6">Active</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-muted">Mô tả dự án:</h6>
                        <p>Hệ thống quản lý học tập theo dự án (Project-Based Learning Tracker) giúp sinh viên và giảng viên quản lý sprint, user stories, tasks và đánh giá đồng đội.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Thông tin:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-book text-primary me-2"></i><strong>Học phần:</strong> INS3064</li>
                                    <li><i class="fas fa-chalkboard-teacher text-success me-2"></i><strong>Giảng viên:</strong> Dr. Tạ Chí Hiếu</li>
                                    <li><i class="fas fa-calendar text-info me-2"></i><strong>Học kỳ:</strong> II 2026</li>
                                    <li><i class="fas fa-users text-warning me-2"></i><strong>Số thành viên:</strong> 3</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Tiến độ:</h6>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Sprint hiện tại</small>
                                        <small><strong>Sprint 2</strong></small>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width: 60%">60%</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>User Stories</small>
                                        <small><strong>3/5 Done</strong></small>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 60%">60%</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Tasks</small>
                                        <small><strong>8/12 Done</strong></small>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" style="width: 67%">67%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Thành viên nhóm:</h6>
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-crown text-warning me-2"></i><strong>Bùi Minh Hiếu</strong></span>
                                    <span class="badge bg-primary">Leader</span>
                                </div>
                                <small class="text-muted">22070905@vnu.edu.vn</small>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-user me-2"></i>Lê Văn Thuận</span>
                                    <span class="badge bg-secondary">Member</span>
                                </div>
                                <small class="text-muted">22070984@vnu.edu.vn</small>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span><i class="fas fa-user me-2"></i>Trần Hoàng Minh</span>
                                    <span class="badge bg-secondary">Member</span>
                                </div>
                                <small class="text-muted">22070343@vnu.edu.vn</small>
                            </div>
                        </div>

                        <div class="mt-3 d-grid gap-2">
                            <a href="<?php echo BASE_URL; ?>sprints" class="btn btn-primary">
                                <i class="fas fa-running me-2"></i>Xem Sprint
                            </a>
                            <a href="<?php echo BASE_URL; ?>backlog" class="btn btn-info">
                                <i class="fas fa-clipboard-list me-2"></i>Backlog
                            </a>
                            <a href="<?php echo BASE_URL; ?>tasks" class="btn btn-success">
                                <i class="fas fa-tasks me-2"></i>My Tasks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h4 class="text-primary mb-0">2</h4>
                        <small class="text-muted">Sprints</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-success mb-0">5</h4>
                        <small class="text-muted">User Stories</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-warning mb-0">12</h4>
                        <small class="text-muted">Tasks</small>
                    </div>
                    <div class="col-md-3">
                        <h4 class="text-info mb-0">42h</h4>
                        <small class="text-muted">Tổng giờ</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                        <h5>Velocity</h5>
                        <h3 class="text-primary">22.5</h3>
                        <small class="text-muted">Story points/sprint</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-percentage fa-3x text-success mb-3"></i>
                        <h5>Completion</h5>
                        <h3 class="text-success">67%</h3>
                        <small class="text-muted">Tasks hoàn thành</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-star fa-3x text-warning mb-3"></i>
                        <h5>Đóng góp</h5>
                        <h3 class="text-warning">8.5</h3>
                        <small class="text-muted">Điểm trung bình</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-fire fa-3x text-danger mb-3"></i>
                        <h5>Streak</h5>
                        <h3 class="text-danger">7</h3>
                        <small class="text-muted">Ngày liên tục</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
