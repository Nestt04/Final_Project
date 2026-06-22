<?php
/**
 * System Health Check & Diagnostics
 * Kiểm tra toàn diện hệ thống PBL Tracker
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/constants.php';

// Security: Chỉ cho phép truy cập từ localhost
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die('Access Denied: This tool is only accessible from localhost');
}

$checks = [];

// 1. PHP Version Check
$checks['php'] = [
    'name' => 'PHP Version',
    'value' => PHP_VERSION,
    'status' => version_compare(PHP_VERSION, '8.0.0', '>=') ? 'success' : 'warning',
    'message' => version_compare(PHP_VERSION, '8.0.0', '>=') ? 'OK' : 'Khuyến nghị PHP >= 8.0'
];

// 2. Database Connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS
    );
    $checks['database'] = [
        'name' => 'Database Connection',
        'value' => DB_NAME . '@' . DB_HOST,
        'status' => 'success',
        'message' => 'Kết nối thành công'
    ];
} catch (PDOException $e) {
    $checks['database'] = [
        'name' => 'Database Connection',
        'value' => DB_NAME . '@' . DB_HOST,
        'status' => 'error',
        'message' => 'Lỗi: ' . $e->getMessage()
    ];
}

// 3. Required PHP Extensions
$required_extensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'session'];
$missing_extensions = [];
foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}
$checks['extensions'] = [
    'name' => 'PHP Extensions',
    'value' => count($required_extensions) - count($missing_extensions) . '/' . count($required_extensions),
    'status' => empty($missing_extensions) ? 'success' : 'error',
    'message' => empty($missing_extensions) ? 'Tất cả extensions có sẵn' : 'Thiếu: ' . implode(', ', $missing_extensions)
];

// 4. Directory Permissions
$directories = [
    'Root' => __DIR__ . '/..',
    'Public' => __DIR__,
    'Views' => __DIR__ . '/../views',
    'Src' => __DIR__ . '/../src',
    'Config' => __DIR__ . '/../config'
];

$dir_status = [];
foreach ($directories as $name => $path) {
    $dir_status[$name] = [
        'exists' => file_exists($path),
        'readable' => is_readable($path),
        'writable' => is_writable($path)
    ];
}

$all_dirs_ok = true;
foreach ($dir_status as $status) {
    if (!$status['exists'] || !$status['readable']) {
        $all_dirs_ok = false;
        break;
    }
}

$checks['directories'] = [
    'name' => 'Directory Structure',
    'value' => count($directories) . ' directories',
    'status' => $all_dirs_ok ? 'success' : 'error',
    'message' => $all_dirs_ok ? 'Cấu trúc thư mục OK' : 'Có vấn đề với thư mục'
];

// 5. Configuration Files
$config_files = [
    'constants.php' => __DIR__ . '/../config/constants.php',
    'database.php' => __DIR__ . '/../config/database.php'
];

$all_configs_ok = true;
foreach ($config_files as $name => $path) {
    if (!file_exists($path)) {
        $all_configs_ok = false;
        break;
    }
}

$checks['config'] = [
    'name' => 'Configuration Files',
    'value' => count($config_files) . ' files',
    'status' => $all_configs_ok ? 'success' : 'error',
    'message' => $all_configs_ok ? 'Tất cả config files OK' : 'Thiếu config files'
];

// 6. Database Tables
$tables_required = ['users', 'courses', 'project_groups', 'sprints', 'user_stories', 'tasks'];
$tables_found = [];
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SHOW TABLES");
        $tables_found = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        $tables_found = [];
    }
}

$missing_tables = array_diff($tables_required, $tables_found);
$checks['tables'] = [
    'name' => 'Database Tables',
    'value' => count($tables_found) . ' tables',
    'status' => empty($missing_tables) ? 'success' : 'warning',
    'message' => empty($missing_tables) ? 'Tất cả bảng đã tồn tại' : 'Thiếu: ' . implode(', ', $missing_tables)
];

// 7. Session Check
$checks['session'] = [
    'name' => 'Session Support',
    'value' => session_status() === PHP_SESSION_DISABLED ? 'Disabled' : 'Enabled',
    'status' => session_status() !== PHP_SESSION_DISABLED ? 'success' : 'error',
    'message' => session_status() !== PHP_SESSION_DISABLED ? 'Session hoạt động bình thường' : 'Session bị tắt'
];

// 8. Memory Limit
$memory_limit = ini_get('memory_limit');
$checks['memory'] = [
    'name' => 'Memory Limit',
    'value' => $memory_limit,
    'status' => 'success',
    'message' => 'Giới hạn bộ nhớ PHP'
];

// 9. Upload Settings
$upload_max = ini_get('upload_max_filesize');
$post_max = ini_get('post_max_size');
$checks['upload'] = [
    'name' => 'File Upload',
    'value' => 'Max: ' . $upload_max . ' / Post: ' . $post_max,
    'status' => 'success',
    'message' => 'Cài đặt upload file'
];

// 10. Timezone
$checks['timezone'] = [
    'name' => 'Timezone',
    'value' => date_default_timezone_get(),
    'status' => 'success',
    'message' => 'Current time: ' . date('Y-m-d H:i:s')

];

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Health Check - PBL Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 40px 0; }
        .check-container { max-width: 1200px; margin: 0 auto; }
        .check-card { background: white; border-radius: 15px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .check-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 15px 15px 0 0; }
        .status-success { color: #28a745; }
        .status-warning { color: #ffc107; }
        .status-error { color: #dc3545; }
        .check-item { padding: 20px; border-bottom: 1px solid #eee; transition: all 0.3s; }
        .check-item:hover { background: #f8f9fa; }
        .check-item:last-child { border-bottom: none; }
        .badge-status { font-size: 14px; padding: 8px 16px; }
    </style>
</head>
<body>
    <div class="check-container">
        <div class="check-card">
            <div class="check-header text-center">
                <h1><i class="fas fa-heartbeat me-3"></i>System Health Check</h1>
                <p class="mb-0">PBL Tracker - Diagnostics & Status</p>
            </div>
            
            <div class="p-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Thông tin:</strong> Trang này kiểm tra toàn diện sức khỏe hệ thống. Chỉ truy cập được từ localhost.
                </div>

                <?php foreach ($checks as $key => $check): ?>
                <div class="check-item">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5 class="mb-0">
                                <?php if ($check['status'] === 'success'): ?>
                                    <i class="fas fa-check-circle status-success me-2"></i>
                                <?php elseif ($check['status'] === 'warning'): ?>
                                    <i class="fas fa-exclamation-triangle status-warning me-2"></i>
                                <?php else: ?>
                                    <i class="fas fa-times-circle status-error me-2"></i>
                                <?php endif; ?>
                                <?php echo $check['name']; ?>
                            </h