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
    <title>Activity Log | <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
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
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="fas fa-history me-2"></i>Activity Log</h2>
                <p class="text-muted">Lịch sử hoạt động và thay đổi trong dự án</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-success">
                    <i class="fas fa-download me-2"></i>Export CSV
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">Tất cả người dùng</option>
                            <option value="1">Lê Văn Thuận</option>
                            <option value="2">Bùi Minh Hiếu</option>
                            <option value="3">Trần Hoàng Minh</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">Tất cả hành động</option>
                            <option value="create">Create</option>
                            <option value="update">Update</option>
                            <option value="delete">Delete</option>
                            <option value="status_change">Status Change</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option value="">Tất cả entity</option>
                            <option value="task">Task</option>
                            <option value="user_story">User Story</option>
                            <option value="sprint">Sprint</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Lọc
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-stream me-2"></i>Timeline (Hôm nay)</h5>
                    </div>
                    <div class="card-body">
                        <!-- Activity 1 -->
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">
                                        <strong><?php echo htmlspecialchars($userName); ?></strong> đã hoàn thành task
                                    </h6>
                                    <small class="text-muted">2 phút trước</small>
                                </div>
                                <p class="text-muted mb-2">Task "Create course form UI" → Status changed to DONE
</p>
                                <div class="card bg-light">
                                    <div class="card-body p-2">
                                        <small class="text-muted">
                                            <strong>Entity:</strong> task #1 | 
                                            <strong>Sprint:</strong> Sprint 2 |
                                            <strong>IP:</strong> 127.0.0.1
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 2 -->
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-edit"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">
                                        <strong>Lê Văn Thuận</strong> đã cập nhật user story
                                    </h6>
                                    <small class="text-muted">1 giờ trước</small>
                                </div>
                                <p class="text-muted mb-2">User Story "Course management CRUD" → Priority changed from MEDIUM to HIGH</p>
                                <div class="card bg-light">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-danger"><del>Old: priority = medium</del></small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-success"><strong>New: priority = high</strong></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 3 -->
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-plus"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">
                                        <strong>Bùi Minh Hiếu</strong> đã tạo task mới
                                    </h6>
                                    <small class="text-muted">3 giờ trước</small>
                                </div>
                                <p class="text-muted mb-2">Task "Sprint planning interface" được tạo trong User Story #4</p>
                                <div class="card bg-light">
                                    <div class="card-body p-2">
                                        <small class="text-muted">
                                            <strong>Assigned to:</strong> Bùi Minh Hiếu | 
                                            <strong>Priority:</strong> High |
                                            <strong>Estimated:</strong> 6h
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity 4 -->
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-comment"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">
                                        <strong>Trần Hoàng Minh</strong> đã comment trên task
                                    </h6>
                                    <small class="text-muted">5 giờ trước</small>
                                </div>
                                <p class="text-muted mb-2">Comment on Task #3: "Đã test xong validation, working fine!"</p>
                            </div>
                        </div>

                        <!-- Activity 5 -->
                        <div class="d-flex mb-4">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">
                                        <strong>Lê Văn Thuận</strong> đã xóa task
                                    </h6>
                                    <small class="text-muted">Hôm qua</small>
                                </div>
                                <p class="text-muted mb-2">Task "Duplicate test task" was deleted (duplicate)</p>
                            </div>
                        </div>

                        <!-- Load More -->
                        <div class="text-center">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-chevron-down me-2"></i>Xem thêm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-3x text-primary mb-2"></i>
                        <h4 class="text-primary">142</h4>
                        <small class="text-muted">Tổng activities</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-plus fa-3x text-success mb-2"></i>
                        <h4 class="text-success">45</h4>
                        <small class="text-muted">Created</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-edit fa-3x text-warning mb-2"></i>
                        <h4 class="text-warning">82</h4>
                        <small class="text-muted">Updated</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-trash fa-3x text-danger mb-2"></i>
                        <h4 class="text-danger">15</h4>
                        <small class="text-muted">Deleted</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
