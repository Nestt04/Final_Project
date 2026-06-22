<?php
/**
 * Application Constants
 * 
 * INS3064 - MULTIMEDIA DESIGN AND WEB DEVELOPMENT
 * Project: Student Project - PBL Tracker
 */

// Application settings
define('APP_NAME', 'PBL Tracker');
define('APP_VERSION', '3.3.0');
define('APP_ENV', 'development'); // development, production

// URL settings
define('BASE_URL', 'http://localhost/studentproject/public/');
define('BASE_PATH', '/studentproject/public/');

// Path settings
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('VIEW_PATH', ROOT_PATH . '/views');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Session settings
define('SESSION_LIFETIME', 7200); // 2 hours in seconds
define('SESSION_NAME', 'PBL_TRACKER_SESSION');

// Security settings
// Password hashing uses PASSWORD_BCRYPT with cost 10 (defined in repositories)

// Pagination
define('ITEMS_PER_PAGE', 20);

// Date format
define('DATE_FORMAT', 'Y-m-d');
define('DATETIME_FORMAT', 'Y-m-d H:i:s');
define('DISPLAY_DATE_FORMAT', 'd/m/Y');
define('DISPLAY_DATETIME_FORMAT', 'd/m/Y H:i');

// Upload settings
define('UPLOAD_MAX_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);

// User roles
define('ROLE_ADMIN', 'admin');
define('ROLE_LECTURER', 'lecturer');
define('ROLE_STUDENT', 'student');

// Sprint status
define('SPRINT_STATUS_PLANNING', 'planning');
define('SPRINT_STATUS_ACTIVE', 'active');
define('SPRINT_STATUS_COMPLETED', 'completed');
define('SPRINT_STATUS_CANCELLED', 'cancelled');

// Task status
define('TASK_STATUS_TODO', 'todo');
define('TASK_STATUS_IN_PROGRESS', 'in_progress');
define('TASK_STATUS_REVIEW', 'review');
define('TASK_STATUS_DONE', 'done');

// User story status
define('STORY_STATUS_BACKLOG', 'backlog');
define('STORY_STATUS_TODO', 'todo');
define('STORY_STATUS_IN_PROGRESS', 'in_progress');
define('STORY_STATUS_DONE', 'done');

// Priority levels
define('PRIORITY_LOW', 'low');
define('PRIORITY_MEDIUM', 'medium');
define('PRIORITY_HIGH', 'high');
define('PRIORITY_CRITICAL', 'critical');
