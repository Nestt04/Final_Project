<?php
/**
 * Database Configuration
 * 
 * INS3064 - MULTIMEDIA DESIGN AND WEB DEVELOPMENT
 * Project: Student Project - PBL Tracker
 * Team: Lê Văn Thuận, Bùi Minh Hiếu, Trần Hoàng Minh
 */

// Database connection settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'pbl_tracker');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Database options
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
]);
