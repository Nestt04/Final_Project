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
    <title>Peer Review | <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <style>
        .rating-star { cursor: pointer; font-size: 24px; color: #ccc; transition: color 0.2s; }
        .rating-star.active, .rating-star:hover { color: #ffc107; }
    </style>
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
        <h2 class="mb-4"><i class="fas fa-star me-2"></i>Peer Review - Đánh giá đồng đội</h2>

        <!-- Instructions -->
        <div class="alert alert-info">
            <h5><i class="fas fa-info-circle me-2"></i>Hướng dẫn</h5>
            <p class="mb-0">Đánh giá các thành viên trong nhóm dựa trên 4 tiêu chí. Điểm từ 1-10 (10 là tốt nhất). Đánh giá của bạn sẽ giúp cải thiện hiệu suất làm việc nhóm.</p>
        </div>

        <!-- Sprint Selection -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Chọn Sprint:</label>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select">
                            <option>Sprint 2 - Core Features (Đang diễn ra)</option>
                            <option>Sprint 1 - Foundation & Database (Đã kết thúc)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Xem
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Review Forms -->
            <div class="col-md-8">
                <!-- Member 1 -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">Bùi Minh hiếu</h5>
                                <small>Team Leader | 22070905@vnu.edu.vn</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <!-- Technical Score -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-code me-2 text-primary"></i>1. Kỹ thuật (Technical Skills)
                                </label>
                                <p class="text-muted small">Khả năng giải quyết vấn đề kỹ thuật, code quality, best practices</p>
                                <div class="d-flex gap-2 mb-2">
                                    <span class="rating-star" data-value="1">★</span>
                                    <span class="rating-star" data-value="2">★</span>
                                    <span class="rating-star" data-value="3">★</span>
                                    <span class="rating-star" data-value="4">★</span>
                                    <span class="rating-star" data-value="5">★</span>
                                    <span class="rating-star" data-value="6">★</span>
                                    <span class="rating-star" data-value="7">★</span>
                                    <span class="rating-star" data-value="8">★</span>
                                    <span class="rating-star active" data-value="9">★</span>
                                    <span class="rating-star active" data-value="10">★</span>
                                    <span class="ms-2 fw-bold text-warning">10/10</span>
                                </div>
                            </div>

                            <!-- Collaboration Score -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-users me-2 text-success"></i>2. Hợp tác (Collaboration)
                                </label>
                                <p class="text-muted small">Làm việc nhóm, hỗ trợ thành viên, chia sẻ kiến thức</p>
                                <div class="d-flex gap-2 mb-2">
                                    <span class="rating-star" data-value="1">★</span>
                                    <span class="rating-star" data-value="2">★</span>
                                    <span class="rating-star" data-value="3">★</span>
                                    <span class="rating-star" data-value="4">★</span>
                                    <span class="rating-star" data-value="5">★</span>
                                    <span class="rating-star" data-value="6">★</span>
                                    <span class="rating-star" data-value="7">★</span>
                                    <span class="rating-star active" data-value="8">★</span>
                                    <span class="rating-star active" data-value="9">★</span>
                                    <span class="rating-star" data-value="10">★</span>
                                    <span class="ms-2 fw-bold text-warning">9/10</span>
                                </div>
                            </div>

                            <!-- Communication Score -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-comments me-2 text-info"></i>3. Giao tiếp (Communication)
                                </label>
                                <p class="text-muted small">Truyền đạt ý tưởng rõ ràng, báo cáo tiến độ, phản hồi kịp thời</p>
                                <div class="d-flex gap-2 mb-2">
                                    <span class="rating-star" data-value="1">★</span>
                                    <span class="rating-star" data-value="2">★</span>
                                    <span class="rating-star" data-value="3">★</span>
                                    <span class="rating-star" data-value="4">★</span>
                                    <span class="rating-star" data-value="5">★</span>
                                    <span class="rating-star" data-value="6">★</span>
                                    <span class="rating-star" data-value="7">★</span>
                                    <span class="rating-star" data-value="8">★</span>
                                    <span class="rating-star active" data-value="9">★</span>
                                    <span class="rating-star active" data-value="10">★</span>
                                    <span class="ms-2 fw-bold text-warning">10/10</span>
                                </div>
                            </div>

                            <!-- Contribution Score -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-hands-helping me-2 text-warning"></i>4. Đóng góp (Contribution)
                                </label>
                                <p class="text-muted small">Số lượng và chất lượng công việc 
àn thành</p>
                                <div class="d-flex gap-2 mb-2">
                                    <span class="rating-star" data-value="1">★</span>
                                    <span class="rating-star" data-value="2">★</span>
                                    <span class="rating-star" data-value="3">★</span>
                                    <span class="rating-star" data-value="4">★</span>
                                    <span class="rating-star" data-value="5">★</span>
                                    <span class="rating-star" data-value="6">★</span>
                                    <span class="rating-star" data-value="7">★</span>
                                    <span class="rating-star" data-value="8">★</span>
                                    <span class="rating-star active" data-value="9">★</span>
                                    <span class="rating-star active" data-value="10">★</span>
                                    <span class="ms-2 fw-bold text-warning">10/10</span>
                                </div>
                            </div>

                            <!-- Comment -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-comment me-2"></i>Nhận xét (Tùy chọn)
                                </label>
                                <textarea class="form-control" rows="3" placeholder="Chia sẻ nhận xét của bạn về thành viên này..."></textarea>
                            </div>

                            <!-- Anonymous Option -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="anonymous1">
                                <label class="form-check-label" for="anonymous1">
                                    Đánh giá ẩn danh 
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Member 2 -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-circle fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-0">Lê Văn Thuận</h5>
                                <small>Member | 22070984@vnu.edu.vn</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-hourglass-half me-2"></i>
                            Bạn chưa đánh giá thành viên này
                        </div>
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-star me-2"></i>Bắt đầu đánh giá
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Summary -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Tóm tắt</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h3 class="text-warning mb-0">2/3</h3>
                            <small class="text-muted">Đã đánh giá</small>
                        </div>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-warning" style="width: 67%">67%</div>
                        </div>
                        <div class="alert alert-info mb-0">
                            <small><i class="fas fa-info-circle me-1"></i>Còn 1 thành viên chưa đánh giá</small>
                        </div>
                    </div>
                </div>

                <!-- My Ratings -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-user me-2"></i>Điểm của tôi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <h4 class="text-primary mb-0">9.2</h4>
                                <small class="text-muted">Kỹ thuật</small>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-success mb-0">8.8</h4>
                                <small class="text-muted">Hợp tác</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info mb-0">9.0</h4>
                                <small class="text-muted">Giao tiếp</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning mb-0">9.5</h4>
                                <small class="text-muted">Đóng góp</small>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h3 class="text-success">9.1</h3>
                            <small class="text-muted">Điểm trung bình</small>
                        </div>
                    </div>
                </div>

                <!-- Guidelines -->
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i>Hướng dẫn chấm điểm</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><strong>9-10:</strong> Xuất sắc</li>
                            <li class="mb-2"><strong>7-8:</strong> Tốt</li>
                            <li class="mb-2"><strong>5-6:</strong> Trung bình</li>
                            <li class="mb-2"><strong>3-4:</strong> Cần cải thiện</li>
                            <li><strong>1-2:</strong> Yếu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Rating stars interaction
        document.querySelectorAll('.rating-star').forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-value'));
                const parent = this.parentElement;
                const stars = parent.querySelectorAll('.rating-star');
                
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
                
                // Update display
                const display = parent.querySelector('span:last-child');
                if (display) {
                    display.textContent = rating + '/10';
                }
            });
        });
    </script
>
</body>
</html>
