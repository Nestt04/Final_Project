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
    <title>Task của tôi | <?php echo APP_NAME; ?></title>
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

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="fas fa-tasks me-2"></i>Task của tôi</h2>
                <p class="text-muted">Quản lý và theo dõi tiến độ công việc</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="fas fa-plus me-2"></i>Thêm Task Mới
                </button>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm task theo tên...">
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <select id="statusFilter" class="form-select">
                            <option value="">Tất cả trạng thái</option>
                            <option value="todo">Todo</option>
                            <option value="in_progress">In Progress</option>
                            <option value="review">Review</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <select id="priorityFilter" class="form-select">
                            <option value="">Tất cả ưu tiên</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <select id="sprintFilter" class="form-select">
                            <option value="">Tất cả sprint</option>
                            <option value="sprint-1">Sprint 1</option>
                            <option value="sprint-2">Sprint 2</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button id="resetFilter" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div id="filterStatus" class="alert alert-info py-2 mb-0" style="display: none;">
                            <i class="fas fa-info-circle me-2"></i>
                            <span id="filterText"></span>
                            <button type="button" class="btn-close float-end" onclick="resetAllFilters()"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanban Board -->
        <div class="row">
            <!-- TODO Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="fas fa-inbox me-2"></i>TODO (<span class="todo-count">2</span>)</h6>
                    </div>
                    <div class="card-body p-2 task-column" id="todo-column" style="min-height: 500px;">
                        <!-- Task Card -->
                        <div class="card mb-2 shadow-sm task-card" data-status="todo" data-priority="high" data-sprint="sprint-2" data-id="1">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-danger">High</span>
                                    <small class="text-muted">#TASK-001</small>
                                </div>
                                <h6 class="card-title task-title">Create course form UI</h6>
                                <p class="card-text small text-muted">Design and implement course creation form with validation</p>
                                <div class="mb-2">
                                    <small class="text-muted"><i class="fas fa-layer-group me-1"></i>Sprint 2</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><i class="fas fa-calendar me-1"></i>23/05/2026</small>
                                    <div>
                                        <button class="btn btn-sm btn-primary" title="Bắt đầu" onclick="changeStatus(1, 'in_progress')">
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>task-detail?id=1" class="btn btn-sm btn-info" title="Chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2 shadow-sm task-card" data-status="todo" data-priority="medium" data-sprint="sprint-2" data-id="2">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-warning">Medium</span>
                                    <small class="text-muted">#TASK-002</small>
                                </div>
                                <h6 class="card-title task-title">Edit course functionality</h6>
                                <p class="card-text small text-muted">Allow editing existing courses with validation</p>
                                <div class="mb-2">
                                    <small class="text-muted"><i class="fas fa-layer-group me-1"></i>Sprint 2</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><i class="fas fa-calendar me-1"></i>25/05/2026</small>
                                    <div>
                                        <button class="btn btn-sm btn-primary" title="Bắt đầu" onclick="changeStatus(2, 'in_progress')">
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>task-detail?id=2" class="btn btn-sm btn-info" title="Chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3 empty-column" style="display: none;">
                            <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                            <p class="text-muted">Không có task</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IN PROGRESS Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-spinner me-2"></i>IN PROGRESS (<span class="in_progress-count">1</span>)</h6>
                    </div>
                    <div class="card-body p-2 task-column" id="in_progress-column" style="min-height: 500px;">
                        <div class="card mb-2 shadow-sm task-card" data-status="in_progress" data-priority="high" data-sprint="sprint-2" data-id="3">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-danger">High</span>
                                    <small class="text-muted">#TASK-003</small>
                                </div>
                                <h6 class="card-title task-title">Course list view pagination</h6>
                                <p class="card-text small text-muted">Display courses in table with search and pagination</p>
                                <div class="mb-2">
                                    <small class="text-muted"><i class="fas fa-layer-group me-1"></i>Sprint 2</small>
                                </div>
                                <div class="progress mb-2" style="height: 5px;">
                                    <div class="progress-bar bg-warning" style="width: 60%"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><i class="fas fa-clock me-1"></i>29/05/2026</small>
                                    <div>
                                        <button class="btn btn-sm btn-success" title="Hoàn thành" onclick="changeStatus(3, 'done')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>task-detail?id=3" class="btn btn-sm btn-info" title="Chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3 empty-column" style="display: none;">
                            <i class="fas fa-spinner fa-3x text-muted mb-2"></i>
                            <p class="text-muted">Không có task</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REVIEW Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-search me-2"></i>REVIEW (<span class="review-count">1</span>)</h6>
                    </div>
                    <div class="card-body p-2 task-column" id="review-column" style="min-height: 500px;">
                        <div class="card mb-2 shadow-sm task-card" data-status="review" data-priority="medium" data-sprint="sprint-2" data-id="4">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-warning">Medium</span>
                                    <small class="text-muted">#TASK-004</small>
                                </div>
                                <h6 class="card-title task-title">Database schema design</h6>
                                <p class="card-text small text-muted">Design database and relationships</p>
                                <div class="mb-2">
                                    <small class="text-muted"><i class="fas fa-layer-group me-1"></i>Sprint 2</small>
                                </div>
                                <div class="alert alert-info p-2 mb-2">
                                    <small><i class="fas fa-user me-1"></i>Đang chờ kiểm tra từ Leader</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><i class="fas fa-check me-1"></i>Hoàn thành</small>
                                    <div>
                                        <button class="btn btn-sm btn-success btn-sm" title="Approve" onclick="changeStatus(4, 'done')">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>task-detail?id=4" class="btn btn-sm btn-info" title="Chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3 empty-column" style="display: none;">
                            <i class="fas fa-search fa-3x text-muted mb-2"></i>
                            <p class="text-muted">Không có task</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DONE Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="fas fa-check-circle me-2"></i>DONE (<span class="done-count">2</span>)</h6>
                    </div>
                    <div class="card-body p-2 task-column" id="done-column" style="min-height: 500px;">
                        <div class="card mb-2 shadow-sm task-card" data-status="done" data-priority="high" data-sprint="sprint-1" data-id="5">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-success">Done</span>
                                    <small class="text-muted">#TASK-005</small>
                                </div>
                                <h6 class="card-title task-title">Setup project structure</h6>
                                <p class="card-text small text-muted">Initialize project with MVC pattern</p>
                                <div class="mb-2">
                                    <small class="text-muted"><i class="fas fa-layer-group me-1"></i>Sprint 1</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><i class="fas fa-calendar-check me-1"></i>30/05/2026</small>
                                    <a href="<?php echo BASE_URL; ?>task-detail?id=5" class="btn btn-sm btn-info" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2 shadow-sm task-card" data-status="done" data-priority="high" data-sprint="sprint-1" data-id="6">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-success">Done</span>
                                    <small class="text-muted">#TASK-006</small>
                                </div>
                                <h6 class="card-title task-title">Authentication system</h6>
                                <p class="card-text small text-muted">Implement login/logout functionality</p>
                                <div class="mb-2">
                                    <small class="text-muted"><i class="fas fa-layer-group me-1"></i>Sprint 1</small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small><i class="fas fa-calendar-check me-1"></i>05/06/2026</small>
                                    <a href="<?php echo BASE_URL; ?>task-detail?id=6" class="btn btn-sm btn-info" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3 empty-column" style="display: none;">
                            <i class="fas fa-check-circle fa-3x text-muted mb-2"></i>
                            <p class="text-muted">Không có task</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Thêm Task Mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề task</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả chi tiết</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">User Story</label>
                                <select class="form-select" required>
                                    <option value="">Chọn user story...</option>
                                    <option value="1">Course management CRUD</option>
                                    <option value="2">Sprint management</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ưu tiên</label>
                                <select class="form-select" required>
                                    <option value="high">High</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giờ ước lượng</label>
                                <input type="number" class="form-control" step="0.5" value="4">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Deadline</label>
                                <input type="date" class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Tạo Task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter và Search functionality
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const priorityFilter = document.getElementById('priorityFilter');
        const sprintFilter = document.getElementById('sprintFilter');
        const resetButton = document.getElementById('resetFilter');
        const filterStatus = document.getElementById('filterStatus');
        const filterText = document.getElementById('filterText');

        // Apply filters
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStatus = statusFilter.value;
            const selectedPriority = priorityFilter.value;
            const selectedSprint = sprintFilter.value;

            const taskCards = document.querySelectorAll('.task-card');
            let visibleCount = 0;
            let statusCounts = { todo: 0, in_progress: 0, review: 0, done: 0 };

            taskCards.forEach(card => {
                const title = card.querySelector('.task-title').textContent.toLowerCase();
                const status = card.getAttribute('data-status');
                const priority = card.getAttribute('data-priority');
                const sprint = card.getAttribute('data-sprint');

                // Check all filters
                const matchesSearch = title.includes(searchTerm);
                const matchesStatus = !selectedStatus || status === selectedStatus;
                const matchesPriority = !selectedPriority || priority === selectedPriority;
                const matchesSprint = !selectedSprint || sprint === selectedSprint;

                // Show/hide card
                if (matchesSearch && matchesStatus && matchesPriority && matchesSprint) {
                    card.style.display = 'block';
                    visibleCount++;
                    statusCounts[status]++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update column counts
            document.querySelector('.todo-count').textContent = statusCounts.todo;
            document.querySelector('.in_progress-count').textContent = statusCounts.in_progress;
            document.querySelector('.review-count').textContent = statusCounts.review;
            document.querySelector('.done-count').textContent = statusCounts.done;

            // Show/hide empty state for each column
            updateEmptyStates();

            // Update filter status message
            updateFilterStatus(searchTerm, selectedStatus, selectedPriority, selectedSprint, visibleCount);
        }

        // Update empty states for columns
        function updateEmptyStates() {
            const columns = document.querySelectorAll('.task-column');
            columns.forEach(column => {
                const visibleCards = column.querySelectorAll('.task-card[style*="display: block"]');
                const emptyState = column.querySelector('.empty-column');
                
                if (visibleCards.length === 0) {
                    emptyState.style.display = 'block';
                } else {
                    emptyState.style.display = 'none';
                }
            });
        }

        // Update filter status message
        function updateFilterStatus(search, status, priority, sprint, count) {
            const filters = [];
            
            if (search) filters.push(`Tìm kiếm: "${search}"`);
            if (status) filters.push(`Trạng thái: ${status.replace('_', ' ')}`);
            if (priority) filters.push(`Ưu tiên: ${priority}`);
            if (sprint) filters.push(`Sprint: ${sprint.replace('sprint-', 'Sprint ')}`);

            if (filters.length > 0) {
                filterStatus.style.display = 'block';
                filterText.innerHTML = `<strong>Đang lọc:</strong> ${filters.join(' | ')} 
                                       <span class="badge bg-primary ms-2">${count} task</span>`;
            } else {
                filterStatus.style.display = 'none';
            }
        }

        // Reset all filters
        function resetAllFilters() {
            searchInput.value = '';
            statusFilter.value = '';
            priorityFilter.value = '';
            sprintFilter.value = '';
            applyFilters();
        }

        // Change task status (demo - sẽ connect với backend sau)
        function changeStatus(taskId, newStatus) {
            if (confirm(`Bạn muốn chuyển task này sang trạng thái "${newStatus.toUpperCase()}"?`)) {
                // Demo: di chuyển card sang column mới
                const card = document.querySelector(`.task-card[data-id="${taskId}"]`);
                const targetColumn = document.getElementById(`${newStatus}-column`);
                
                if (card && targetColumn) {
                    // Update card status
                    card.setAttribute('data-status', newStatus);
                    
                    // Move card to new column
                    targetColumn.insertBefore(card, targetColumn.firstChild);
                    
                    // Update badge
                    const badge = card.querySelector('.badge');
                    badge.className = 'badge';
                    if (newStatus === 'done') {
                        badge.classList.add('bg-success');
                        badge.textContent = 'Done';
                    } else if (newStatus === 'in_progress') {
                        badge.classList.add('bg-warning');
                        badge.textContent = 'In Progress';
                    } else if (newStatus === 'review') {
                        badge.classList.add('bg-info');
                        badge.textContent = 'Review';
                    }
                    
                    // Reapply filters to update counts
                    applyFilters();
                    
                    // Show success message
                    showToast('✅ Cập nhật trạng thái thành công!');
                }
            }
        }

        // Show toast notification
        function showToast(message) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'position-fixed top-0 end-0 p-3';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header bg-success text-white">
                        <strong class="me-auto">Thông báo</strong>
                        <button type="button" class="btn-close btn-close-white" onclick="this.closest('.position-fixed').remove()"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Event listeners
        searchInput.addEventListener('input', applyFilters);
        statusFilter.addEventListener('change', applyFilters);
        priorityFilter.addEventListener('change', applyFilters);
        sprintFilter.addEventListener('change', applyFilters);
        resetButton.addEventListener('click', resetAllFilters);

        // Initial load
        updateEmptyStates();
    </script>
</body>
</html>
