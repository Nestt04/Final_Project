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
    <title>Backlog | <?php echo APP_NAME; ?></title>
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
                <h2><i class="fas fa-clipboard-list me-2"></i>Product Backlog</h2>
                <p class="text-muted">Quản lý User Stories và phân bổ vào Sprint</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStoryModal">
                    <i class="fas fa-plus me-2"></i>Thêm User Story
                </button>
            </div>
        </div>

        <!-- Filter & Stats -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Tìm kiếm user story...">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="backlog">Backlog</option>
                                    <option value="ready">Ready</option>
                                    <option value="in_sprint">In Sprint</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option value="">Tất cả priority</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4 class="mb-0">12 / 45</h4>
                        <small>Story Points In Sprint / Total</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backlog Table -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>User Stories</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 80px;">Priority</th>
                                <th>Title</th>
                                <th style="width: 100px;">Points</th>
                                <th style="width: 120px;">Status</th>
                                <th style="width: 100px;">Sprint</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Story 1 -->
                            <tr>
                                <td><strong>US-01</strong></td>
                                <td><span class="badge bg-danger">High</span></td>
                                <td>
                                    <strong>Course management CRUD operations</strong>
                                    <br>
                                    <small class="text-muted">As a lecturer, I want to create/edit/delete courses</small>
                                </td>
                                <td><h5 class="mb-0 text-warning">8</h5></td>
                                <td><span class="badge bg-warning">In Sprint</span></td>
                                <td><span class="badge bg-info">Sprint 2</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Move to Sprint">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Story 2 -->
                            <tr>
                                <td><strong>US-02</strong></td>
                                <td><span class="badge bg-danger">High</span></td>
                                <td>
                                    <strong>Sprint planning and capacity management</strong>
                                    <br>
                                    <small class="text-muted">As a team, I want to plan sprints with story points</small>
                                </td>
                                <td><h5 class="mb-0 text-warning">13</h5></td>
                                <td><span class="badge bg-success">Ready</span></td>
                                <td><span class="badge bg-secondary">None</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Move to Sprint">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Story 3 -->
                            <tr>
                                <td><strong>US-03</strong></td>
                                <td><span class="badge bg-warning">Medium</span></td>
                                <td>
                                    <strong>Peer review system</strong>
                                    <br>
                                    <small class="text-muted">As a student, I want to rate team members on 4 criteria</small>
                                </td>
                                <td><h5 class="mb-0 text-warning">5</h5></td>
                                <td><span class="badge bg-secondary">Backlog</span></td>
                                <td><span class="badge bg-secondary">None</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Move to Sprint">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Story 4 -->
                            <tr>
                                <td><strong>US-04</strong></td>
                                <td><span class="badge bg-warning">Medium</span></td>
                                <td>
                                    <strong>Activity logging system</strong>
                                    <br>
                                    <small class="text-muted">As a user, I want to see all project activities in timeline</small>
                                </td>
                                <td><h5 class="mb-0 text-warning">3</h5></td>
                                <td><span class="badge bg-secondary">Backlog</span></td>
                                <td><span class="badge bg-secondary">None</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Move to Sprint">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Story 5 -->
                            <tr>
                                <td><strong>US-05</strong></td>
                                <td><span class="badge bg-info">Low</span></td>
                                <td>
                                    <strong>User profile customization</strong>
                                    <br>
                                    <small class="text-muted">As a user, I want to customize my profile with avatar and bio</small>
                                </td>
                                <td><h5 class="mb-0 text-warning">2</h5></td>
                                <td><span class="badge bg-secondary">Backlog</span></td>
                                <td><span class="badge bg-secondary">None</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" title="Move to Sprint">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h5 class="text-danger mb-0">2</h5>
                        <small class="text-muted">High Priority</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-warning mb-0">2</h5>
                        <small class="text-muted">Medium Priority</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-info mb-0">1</h5>
                        <small class="text-muted">Low Priority</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="text-primary mb-0">31</h5>
                        <small class="text-muted">Total Points</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Story Modal -->
    <div class="modal fade" id="addStoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Thêm User Story Mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" placeholder="e.g., Course management CRUD" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả (User Story Format)</label>
                            <textarea class="form-control" rows="3" placeholder="As a [role], I want to [action], so that [benefit]" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Priority</label>
                                <select class="form-select" required>
                                    <option value="high">High</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Story Points</label>
                                <select class="form-select" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="5" selected>5</option>
                                    <option value="8">8</option>
                                    <option value="13">13</option>
                                    <option value="21">21</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sprint</label>
                                <select class="form-select">
                                    <option value="">Backlog</option>
                                    <option value="2">Sprint 2</option>
                                    <option value="3">Sprint 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Acceptance Criteria</label>
                            <textarea class="form-control" rows="4" placeholder="Danh sách các điều kiện để story được coi là hoàn thành"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Tạo Story
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>