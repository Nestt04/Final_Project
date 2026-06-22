<?php
use App\Core\Session;
$userName = Session::getUserFullName();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin | <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-shield-alt me-2"></i>
                <?php echo APP_NAME; ?> - ADMIN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-shield me-1"></i>
                            <?php echo htmlspecialchars($userName); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Cài đặt hệ thống</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>logout">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="list-group list-group-flush">
                    <a href="<?php echo BASE_URL; ?>admin/dashboard" class="nav-link active">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-users me-2"></i> Quản lý người dùng
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-book me-2"></i> Quản lý học phần
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-project-diagram me-2"></i> Quản lý dự án
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-line me-2"></i> Thống kê & báo cáo
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-history me-2"></i> Activity Log
                    </a>
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog me-2"></i> Cài đặt hệ thống
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-4 py-4">
                <!-- Welcome Header -->
                <div class="dashboard-header text-white rounded p-4 mb-4" style="background: linear-gradient(135deg, #dc3545, #b02a37);">
                    <h2><i class="fas fa-shield-alt me-2"></i> Admin Dashboard</h2>
                    <p class="mb-0">Quản trị toàn hệ thống PBL Tracker</p>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stat-card card-hover position-relative">
                            <i class="fas fa-users icon text-primary"></i>
                            <div class="number text-primary">125</div>
                            <div class="label">Tổng người dùng</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card card-hover position-relative">
                            <i class="fas fa-book icon text-success"></i>
                            <div class="number text-success">8</div>
                            <div class="label">Học phần</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card card-hover position-relative">
                            <i class="fas fa-project-diagram icon text-warning"></i>
                            <div class="number text-warning">25</div>
                            <div class="label">Dự án</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card card-hover position-relative">
                            <i class="fas fa-tasks icon text-info"></i>
                            <div class="number text-info">450</div>
                            <div class="label">Tổng Tasks</div>
                        </div>
                    </div>
                </div>

                <!-- System Overview -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Thống kê người dùng</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-user-graduate text-primary me-2"></i> Sinh viên</span>
                                    <strong>100 người</strong>
                                </div>
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar" style="width: 80%">80%</div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-chalkboard-teacher text-success me-2"></i> Giảng viên</span>
                                    <strong>20 người</strong>
                                </div>
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: 16%">16%</div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-user-shield text-danger me-2"></i> Admin</span>
                                    <strong>5 người</strong>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-danger" style="width: 4%">4%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> Thống kê dự án</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-play-circle text-info me-2"></i> Đang hoạt động</span>
                                    <strong>18 dự án</strong>
                                </div>
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar bg-info" style="width: 72%">72%</div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-check-circle text-success me-2"></i> Hoàn thành</span>
                                    <strong>5 dự án</strong>
                                </div>
                                <div class="progress mb-3" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: 20%">20%</div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-archive text-secondary me-2"></i> Đã lưu trữ</span>
                                    <strong>2 dự án</strong>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-secondary" style="width: 8%">8%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i> Hoạt động hệ thống gần đây</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Người dùng</th>
                                        <th>Hành động</th>
                                        <th>Chi tiết</th>
                                        <th>IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><small>22/06/2026 10:30</small></td>
                                        <td>Lê Văn Thuận</td>
                                        <td><span class="badge bg-success">CREATE</span></td>
                                        <td>Tạo user story mới "Course CRUD"</td>
                                        <td><small>127.0.0.1</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>22/06/2026 09:15</small></td>
                                        <td>Dr. Nguyen Van A</td>
                                        <td><span class="badge bg-warning">UPDATE</span></td>
                                        <td>Cập nhật thông tin học phần INS3064</td>
                                        <td><small>192.168.1.100</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>21/06/2026 16:45</small></td>
                                        <td>Bùi Minh Hiếu</td>
                                        <td><span class="badge bg-info">STATUS_CHANGE</span></td>
                                        <td>Chuyển task sang "In Progress"</td>
                                        <td><small>127.0.0.1</small></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="fas fa-database fa-3x text-primary mb-3"></i>
                                <h5>Database</h5>
                                <p class="text-muted">MySQL 8.0</p>
                                <span class="badge bg-success">Online</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <i class="fas fa-server fa-3x text-success mb-3"></i>
                                <h5>Web Server</h5>
                                <p class="text-muted">Apache 2.4</p>
                                <span class="badge bg-success">Running</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <i class="fas fa-code fa-3x text-info mb-3"></i>
                                <h5>PHP Version</h5>
                                <p class="text-muted"><?php echo PHP_VERSION; ?></p>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p class="mb-0">
                INS3064 - MULTIMEDIA DESIGN AND WEB DEVELOPMENT<br>
                Trường Quốc tế ISchool - ĐHQGHN © 2026 | Version <?php echo APP_VERSION; ?>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
