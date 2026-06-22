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
    <title>Sprint hiện tại | <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <!-- Sprint Header -->
        <div class="card mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2"><i class="fas fa-running me-2"></i>Sprint 2 - Core Features & CRUD</h2>
                        <p class="mb-0"><i class="fas fa-calendar me-2"></i>15/02/2026 - 28/02/2026 (14 ngày)</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <h1 class="display-4 mb-0">60%</h1>
                        <p class="mb-0">Hoàn thành</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8">
                <!-- Sprint Goal -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Mục tiêu Sprint</h5>
                    </div>
                    <div class="card-body">
                        <p class="lead mb-0">Implement CRUD operations for all entities and complete core features của hệ thống PBL Tracker</p>
                    </div>
                </div>

                <!-- Burndown Chart -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Burndown Chart</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="burndownChart" height="80"></canvas>
                    </div>
                </div>

                <!-- User Stories in Sprint -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i>User Stories (5)</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <!-- Story 1 -->
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-success me-2">DONE</span>
                                            <span class="badge bg-danger me-2">8 points</span>
                                            <h6 class="mb-0">[Thuận] Setup database schema</h6>
                                        </div>
                                        <p class="text-muted small mb-2">As a developer, I want to create 9 database tables with proper relationships</p>
                                        <small class="text-muted">
                                            <i class="fas fa-tasks me-1"></i>4/4 tasks completed
                                        </small>
                                    </div>
                                    <div class="progress" style="width: 100px; height: 100px;">
                                        <svg width="100" height="100">
                                            <circle cx="50" cy="50" r="40" fill="none" stroke="#e9ecef" stroke-width="8"/>
                                            <circle cx="50" cy="50" r="40" fill="none" stroke="#28a745" stroke-width="8"
                                                stroke-dasharray="251.2" stroke-dashoffset="0" transform="rotate(-90 50 50)"/>
                                            <text x="50" y="55" text-anchor="middle" font-size="20" font-weight="bold" fill="#28a745">100%</text>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Story 2 -->
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-warning me-2">IN PROGRESS</span>
                                            <span class="badge bg-warning me-2">5 points</span>
                                            <h6 class="mb-0">[Thuận] Course management CRUD</h6>
                                        </div>
                                        <p class="text-muted small mb-2">As a lecturer, I want to create/edit/delete courses</p>
                                        <small class="text-muted">
                                            <i class="fas fa-tasks me-1"></i>2/4 tasks completed
                                        </small>
                                    </div>
                                    <div class="progress" style="width: 100px; height: 100px;">
                                        <svg width="100" height="100">
                                            <circle cx="50" cy="50" r="40" fill="none" stroke="#e9ecef" stroke-width="8"/>
                                            <circle cx="50" cy="50" r="40" fill="none" stroke="#ffc107" stroke-width="8"
                                                stroke-dasharray="251.2" stroke-dashoffset="125.6" transform="rotate(-90 50 50)"/>
                                            <text x="50" y="55" text-anchor="middle" font-size="20" font-weight="bold" fill="#ffc107">50%</text>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Story 3 -->
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-secondary me-2">TODO</span>
                                            <span class="badge bg-danger me-2">8 points</span>
                                            <h6 class="mb-0">[Hiếu] Sprint management & planning</h6>
                                        </div>
                                        <p class="text-muted small mb-2">As a team, I want to manage sprints with capacity planning</p>
                                        <small class="text-muted">
                                            <i class="fas fa-tasks me-1"></i>0/6 tasks completed
                                        </small>
                                    </div>
                                    <div class="progress" style="width: 100px; height: 100px;">
                                        <svg width="100" height="100">
                                            <circle cx="50" cy="50" r="40" fill="none" stroke="#e9ecef" stroke-width="8"/>
                                            <text x="50" y="55" text-anchor="middle" font-size="20" font-weight="bold" fill="#6c757d">0%</text>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <!-- Time Remaining -->
                <div class="card mb-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-hourglass-half fa-3x text-warning mb-3"></i>
                        <h2 class="text-warning">6 ngày</h2>
                        <p class="text-muted mb-0">Còn lại</p>
                        <hr>
                        <small class="text-muted">Kết thúc: 28/02/2026</small>
                    </div>
                </div>

                <!-- Sprint Stats -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Thống kê</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small>Story Points</small>
                                <small><strong>15/25</strong></small>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: 60%">60%</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small>User Stories</small>
                                <small><strong>3/5</strong></small>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: 60%">60%</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small>Tasks</small>
                                <small><strong>8/12</strong></small>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" style="width: 67%">67%</div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <small>Giờ làm việc</small>
                                <small><strong>28/40h</strong></small>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" style="width: 70%">70%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Velocity -->
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Velocity</h6>
                    </div>
                    <div class="card-body text-center">
                        <h1 class="display-4 text-warning">22.5</h1>
                        <p class="text-muted mb-0">Story points/sprint</p>
                        <hr>
                        <canvas id="velocityChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Burndown Chart
        const ctx1 = document.getElementById('burndownChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Day 1', 'Day 3', 'Day 5', 'Day 7', 'Day 9', 'Day 11', 'Day 13', 'Day 14'],
                datasets: [{
                    label: 'Ideal',
                    data: [25, 21, 18, 14, 11, 7, 4, 0],
                    borderColor: '#6c757d',
                    borderDash: [5, 5],
                    fill: false
                }, {
                    label: 'Actual',
                    data: [25, 23, 20, 18, 15, 12, 10, null],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Story Points' } }
                }
            }
        });

        // Velocity Chart
        const ctx2 = document.getElementById('velocityChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Sprint 1', 'Sprint 2'],
                datasets: [{
                    label: 'Completed Points',
                    data: [20, 15],
                    backgroundColor: ['#28a745', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>
