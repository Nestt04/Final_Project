-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2026 at 09:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentproject_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_calculate_contribution_score` (IN `p_user_id` INT, IN `p_sprint_id` INT, OUT `p_score` DECIMAL(5,2))   BC_LOGIC: BEGIN
    DECLARE v_tasks_completed INT DEFAULT 0;
    DECLARE v_story_points INT DEFAULT 0;
    DECLARE v_peer_avg DECIMAL(5,2) DEFAULT 0;
    
    -- 1. Đếm số task hoàn thành của thành viên
    SELECT COUNT(DISTINCT ta.task_id)
    INTO v_tasks_completed
    FROM task_assignments ta
    JOIN tasks t ON ta.task_id = t.id
    JOIN user_stories us ON t.user_story_id = us.id
    WHERE ta.user_id = p_user_id 
      AND us.sprint_id = p_sprint_id
      AND ta.status = 'completed';
    
    -- 2. Tính tổng story points từ các câu chuyện đã xử lý xong
    SELECT COALESCE(SUM(us.story_points), 0)
    INTO v_story_points
    FROM user_stories us
    JOIN tasks t ON us.id = t.user_story_id
    JOIN task_assignments ta ON t.id = ta.task_id
    WHERE ta.user_id = p_user_id
      AND us.sprint_id = p_sprint_id
      AND ta.status = 'completed';
    
    -- 3. Điểm trung bình đánh giá chéo từ đồng đội
    SELECT AVG((technical_score + collaboration_score + communication_score + contribution_score) / 4)
    INTO v_peer_avg
    FROM peer_reviews
    WHERE reviewee_id = p_user_id
      AND sprint_id = p_sprint_id;
    
    -- 4. Trả về kết quả theo trọng số quy định
    SET p_score = (v_tasks_completed * 2) + (v_story_points * 0.5) + (COALESCE(v_peer_avg, 5) * 1.5);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL COMMENT 'ID log',
  `user_id` int(11) NOT NULL COMMENT 'Người thực hiện hành động',
  `project_group_id` int(11) NOT NULL COMMENT 'Nhóm dự án',
  `entity_type` varchar(50) NOT NULL COMMENT 'Loại entity (sprint, user_story, task, etc)',
  `entity_id` int(11) NOT NULL COMMENT 'ID của entity',
  `action` varchar(50) NOT NULL COMMENT 'Hành động (create, update, delete, status_change)',
  `old_value` text DEFAULT NULL COMMENT 'Giá trị cũ (JSON format)',
  `new_value` text DEFAULT NULL COMMENT 'Giá trị mới (JSON format)',
  `ip_address` varchar(45) DEFAULT NULL COMMENT 'IP address thực hiện',
  `user_agent` varchar(255) DEFAULT NULL COMMENT 'User agent (browser)',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian thực hiện'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Activity logging - Phụ trách: Trần Hoàng Minh';

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `project_group_id`, `entity_type`, `entity_id`, `action`, `old_value`, `new_value`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 3, 1, 'project_group', 1, 'create', NULL, '{\"group_name\":\"Team Alpha\",\"status\":\"active\"}', '127.0.0.1', NULL, '2026-06-22 07:17:27'),
(2, 3, 1, 'user_story', 3, 'create', NULL, '{\"title\":\"Course management CRUD\",\"status\":\"todo\"}', '127.0.0.1', NULL, '2026-06-22 07:17:27'),
(3, 3, 1, 'task', 1, 'create', NULL, '{\"title\":\"Create course form UI\",\"status\":\"todo\"}', '127.0.0.1', NULL, '2026-06-22 07:17:27'),
(4, 3, 1, 'task', 1, 'status_change', NULL, '{\"old\":\"todo\",\"new\":\"in_progress\"}', '127.0.0.1', NULL, '2026-06-22 07:17:27'),
(5, 4, 1, 'user_story', 4, 'create', NULL, '{\"title\":\"Sprint management & planning\",\"status\":\"todo\"}', '127.0.0.1', NULL, '2026-06-22 07:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL COMMENT 'ID học phần',
  `course_code` varchar(20) NOT NULL COMMENT 'Mã học phần (VD: INS3064)',
  `course_name` varchar(200) NOT NULL COMMENT 'Tên học phần',
  `instructor_id` int(11) NOT NULL COMMENT 'Giảng viên phụ trách',
  `semester` varchar(20) NOT NULL COMMENT 'Học kỳ (VD: Spring, Fall)',
  `year` int(11) NOT NULL COMMENT 'Năm học',
  `description` text DEFAULT NULL COMMENT 'Mô tả học phần',
  `max_group_size` int(11) DEFAULT 5 COMMENT 'Số thành viên tối đa/nhóm',
  `start_date` date DEFAULT NULL COMMENT 'Ngày bắt đầu học phần',
  `end_date` date DEFAULT NULL COMMENT 'Ngày kết thúc học phần',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'Trạng thái kích hoạt',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quản lý học phần PBL - Phụ trách: Lê Văn Thuận';

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `instructor_id`, `semester`, `year`, `description`, `max_group_size`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'INS3064', 'Multimedia Design and Web Development', 2, 'Spring', 2026, 'Project-based learning course focusing on web development with design patterns', 5, '2026-01-15', '2026-05-30', 1, '2026-06-22 07:17:27', '2026-06-22 07:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `id` int(11) NOT NULL COMMENT 'ID membership',
  `group_id` int(11) NOT NULL COMMENT 'ID nhóm dự án',
  `user_id` int(11) NOT NULL COMMENT 'ID người dùng',
  `role` enum('leader','member') DEFAULT 'member' COMMENT 'Vai trò trong nhóm',
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tham gia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng trung gian user-group - Phụ trách: Lê Văn Thuận';

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`id`, `group_id`, `user_id`, `role`, `joined_at`) VALUES
(1, 1, 3, 'leader', '2026-06-22 07:17:27'),
(2, 1, 4, 'member', '2026-06-22 07:17:27'),
(3, 1, 5, 'member', '2026-06-22 07:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `peer_reviews`
--

CREATE TABLE `peer_reviews` (
  `id` int(11) NOT NULL COMMENT 'ID đánh giá',
  `sprint_id` int(11) NOT NULL COMMENT 'Sprint được đánh giá',
  `reviewer_id` int(11) NOT NULL COMMENT 'Người đánh giá',
  `reviewee_id` int(11) NOT NULL COMMENT 'Người được đánh giá',
  `technical_score` int(11) NOT NULL COMMENT 'Điểm kỹ thuật (1-10)' CHECK (`technical_score` between 1 and 10),
  `collaboration_score` int(11) NOT NULL COMMENT 'Điểm hợp tác (1-10)' CHECK (`collaboration_score` between 1 and 10),
  `communication_score` int(11) NOT NULL COMMENT 'Điểm giao tiếp (1-10)' CHECK (`communication_score` between 1 and 10),
  `contribution_score` int(11) NOT NULL COMMENT 'Điểm đóng góp (1-10)' CHECK (`contribution_score` between 1 and 10),
  `comment` text DEFAULT NULL COMMENT 'Nhận xét chi tiết',
  `is_anonymous` tinyint(1) DEFAULT 0 COMMENT 'Ẩn danh hay công khai',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian đánh giá',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Peer review system - Phụ trách: Trần Hoàng Minh';

-- --------------------------------------------------------

--
-- Table structure for table `project_groups`
--

CREATE TABLE `project_groups` (
  `id` int(11) NOT NULL COMMENT 'ID nhóm',
  `course_id` int(11) NOT NULL COMMENT 'Học phần',
  `group_name` varchar(100) NOT NULL COMMENT 'Tên nhóm (VD: Team Alpha)',
  `group_code` varchar(20) NOT NULL COMMENT 'Mã nhóm (VD: ALPHA01)',
  `project_topic` varchar(255) DEFAULT NULL COMMENT 'Chủ đề dự án',
  `max_capacity` int(11) DEFAULT 5 COMMENT 'Số thành viên tối đa',
  `status` enum('active','completed','archived') DEFAULT 'active' COMMENT 'Trạng thái nhóm',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quản lý nhóm dự án - Phụ trách: Lê Văn Thuận';

--
-- Dumping data for table `project_groups`
--

INSERT INTO `project_groups` (`id`, `course_id`, `group_name`, `group_code`, `project_topic`, `max_capacity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Team Alpha', 'ALPHA01', 'PBL Tracker System - Quản lý Học tập Theo Dự án', 5, 'active', '2026-06-22 07:17:27', '2026-06-22 07:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `sprints`
--

CREATE TABLE `sprints` (
  `id` int(11) NOT NULL COMMENT 'ID sprint',
  `project_group_id` int(11) NOT NULL COMMENT 'Nhóm dự án',
  `sprint_name` varchar(100) NOT NULL COMMENT 'Tên sprint (VD: Sprint 1 - Foundation)',
  `sprint_number` int(11) NOT NULL COMMENT 'Số thứ tự sprint',
  `start_date` date NOT NULL COMMENT 'Ngày bắt đầu',
  `end_date` date NOT NULL COMMENT 'Ngày kết thúc',
  `goal` text DEFAULT NULL COMMENT 'Mục tiêu sprint',
  `capacity` int(11) DEFAULT 0 COMMENT 'Capacity (tổng story points)',
  `status` enum('planning','active','completed','cancelled') DEFAULT 'planning' COMMENT 'Trạng thái sprint',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quản lý sprint - Phụ trách: Bùi Minh Hiếu';

--
-- Dumping data for table `sprints`
--

INSERT INTO `sprints` (`id`, `project_group_id`, `sprint_name`, `sprint_number`, `start_date`, `end_date`, `goal`, `capacity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sprint 1 - Foundation & Database', 1, '2026-02-01', '2026-02-14', 'Setup project structure, database schema, design patterns', 20, 'completed', '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(2, 1, 'Sprint 2 - Core Features & CRUD', 2, '2026-02-15', '2026-02-28', 'Implement CRUD operations for all entities', 25, 'active', '2026-06-22 07:17:27', '2026-06-22 07:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL COMMENT 'ID task',
  `user_story_id` int(11) NOT NULL COMMENT 'User story cha',
  `title` varchar(255) NOT NULL COMMENT 'Tiêu đề task',
  `description` text DEFAULT NULL COMMENT 'Mô tả chi tiết task',
  `estimated_hours` decimal(5,2) DEFAULT 0.00 COMMENT 'Giờ ước lượng',
  `actual_hours` decimal(5,2) DEFAULT 0.00 COMMENT 'Giờ thực tế đã làm',
  `status` enum('todo','in_progress','review','done') DEFAULT 'todo' COMMENT 'Trạng thái task',
  `priority` enum('low','medium','high') DEFAULT 'medium' COMMENT 'Độ ưu tiên',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quản lý task chi tiết - Phụ trách: Bùi Minh Hiếu';

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `user_story_id`, `title`, `description`, `estimated_hours`, `actual_hours`, `status`, `priority`, `created_at`, `updated_at`) VALUES
(1, 3, 'Create course form UI', 'Design and implement course creation form with validation', 4.00, 0.00, 'in_progress', 'high', '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(2, 3, 'Course list view with pagination', 'Display all courses in a table with search and pagination', 3.00, 0.00, 'todo', 'high', '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(3, 3, 'Edit course functionality', 'Allow editing existing courses with validation', 3.00, 0.00, 'todo', 'medium', '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(4, 3, 'Delete course with confirmation', 'Soft delete with confirmation dialog and cascade handling', 2.00, 0.00, 'todo', 'low', '2026-06-22 07:17:27', '2026-06-22 07:17:27');

--
-- Triggers `tasks`
--
DELIMITER $$
CREATE TRIGGER `trg_task_status_log` AFTER UPDATE ON `tasks` FOR EACH ROW BEGIN
    IF OLD.status != NEW.status THEN
        INSERT INTO activity_logs (user_id, project_group_id, entity_type, entity_id, action, old_value, new_value, ip_address)
        SELECT 
            ta.user_id,
            us.project_group_id,
            'task',
            NEW.id,
            'status_change',
            JSON_OBJECT('status', OLD.status, 'title', OLD.title),
            JSON_OBJECT('status', NEW.status, 'title', NEW.title),
            '127.0.0.1'
        FROM task_assignments ta
        JOIN user_stories us ON NEW.user_story_id = us.id
        WHERE ta.task_id = NEW.id
        LIMIT 1;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `task_assignments`
--

CREATE TABLE `task_assignments` (
  `id` int(11) NOT NULL COMMENT 'ID phân công',
  `task_id` int(11) NOT NULL COMMENT 'Task được phân công',
  `user_id` int(11) NOT NULL COMMENT 'Thành viên được giao task',
  `assigned_by` int(11) NOT NULL COMMENT 'Người phân công (leader/PM)',
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian phân công',
  `started_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian bắt đầu làm',
  `completed_at` timestamp NULL DEFAULT NULL COMMENT 'Thời gian hoàn thành',
  `status` enum('assigned','working','completed','cancelled') DEFAULT 'assigned' COMMENT 'Trạng thái phân công',
  `notes` text DEFAULT NULL COMMENT 'Ghi chú từ người phân công'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Phân công task - Phụ trách: Trần Hoàng Minh';

--
-- Dumping data for table `task_assignments`
--

INSERT INTO `task_assignments` (`id`, `task_id`, `user_id`, `assigned_by`, `assigned_at`, `started_at`, `completed_at`, `status`, `notes`) VALUES
(1, 1, 3, 3, '2026-06-22 07:17:27', NULL, NULL, 'working', 'Đang làm form với Bootstrap 5'),
(2, 2, 4, 3, '2026-06-22 07:17:27', NULL, NULL, 'assigned', 'Hiếu sẽ làm phần list view');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'ID người dùng',
  `email` varchar(100) NOT NULL COMMENT 'Email đăng nhập',
  `password` varchar(255) NOT NULL COMMENT 'Mật khẩu (hashed với bcrypt)',
  `full_name` varchar(100) NOT NULL COMMENT 'Họ tên đầy đủ',
  `role` enum('student','lecturer','admin') NOT NULL DEFAULT 'student' COMMENT 'Vai trò người dùng',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'Đường dẫn ảnh đại diện',
  `phone` varchar(20) DEFAULT NULL COMMENT 'Số điện thoại',
  `student_code` varchar(20) DEFAULT NULL COMMENT 'Mã sinh viên (chỉ dành cho student)',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'Trạng thái kích hoạt tài khoản',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quản lý tài khoản người dùng - Phụ trách: Lê Văn Thuận';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `role`, `avatar`, `phone`, `student_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'admin@ischool.vnu.edu.vn', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'Administrator', 'admin', NULL, NULL, NULL, 1, '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(2, 'lecturer@ischool.vnu.edu.vn', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'Dr. Nguyen Van A', 'lecturer', NULL, NULL, NULL, 1, '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(3, '22070984@vnu.edu.vn', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'Lê Văn Thuận', 'student', NULL, NULL, '22070984', 1, '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(4, '22070905@vnu.edu.vn', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'Bùi Minh Hiếu', 'student', NULL, NULL, '22070905', 1, '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(5, '22070343@vnu.edu.vn', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'Trần Hoàng Minh', 'student', NULL, NULL, '22070343', 1, '2026-06-22 07:17:27', '2026-06-22 07:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_stories`
--

CREATE TABLE `user_stories` (
  `id` int(11) NOT NULL COMMENT 'ID user story',
  `project_group_id` int(11) NOT NULL COMMENT 'Nhóm dự án',
  `sprint_id` int(11) DEFAULT NULL COMMENT 'Sprint (NULL = trong backlog)',
  `title` varchar(255) NOT NULL COMMENT 'Tiêu đề user story',
  `description` text DEFAULT NULL COMMENT 'Mô tả chi tiết',
  `acceptance_criteria` text DEFAULT NULL COMMENT 'Tiêu chí chấp nhận',
  `story_points` int(11) DEFAULT 0 COMMENT 'Điểm ước lượng (Fibonacci)',
  `priority` enum('low','medium','high','critical') DEFAULT 'medium' COMMENT 'Độ ưu tiên',
  `status` enum('backlog','todo','in_progress','done') DEFAULT 'backlog' COMMENT 'Trạng thái',
  `created_by` int(11) NOT NULL COMMENT 'Người tạo story',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Thời gian tạo',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Thời gian cập nhật'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Quản lý user story - Phụ trách: Bùi Minh Hiếu';

--
-- Dumping data for table `user_stories`
--

INSERT INTO `user_stories` (`id`, `project_group_id`, `sprint_id`, `title`, `description`, `acceptance_criteria`, `story_points`, `priority`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '[Thuận] Setup database schema', 'As a developer, I want to create 9 database tables with proper relationships, so that we can store all PBL data', NULL, 8, 'high', 'done', 3, '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(2, 1, 1, '[Thuận] Implement authentication system', 'As a user, I want to login/logout with email and password, so that I can access the system securely', NULL, 5, 'high', 'done', 3, '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(3, 1, 2, '[Thuận] Course management CRUD', 'As a lecturer, I want to create/edit/delete courses, so that I can manage my courses', NULL, 5, 'high', 'in_progress', 3, '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(4, 1, 2, '[Hiếu] Sprint management & planning', 'As a team, I want to manage sprints with capacity planning, so that we can plan our work', NULL, 8, 'high', 'todo', 4, '2026-06-22 07:17:27', '2026-06-22 07:17:27'),
(5, 1, NULL, '[Minh] Peer review system', 'As a student, I want to review my teammates, so that we can give feedback', NULL, 8, 'medium', 'backlog', 5, '2026-06-22 07:17:27', '2026-06-22 07:17:27');

--
-- Triggers `user_stories`
--
DELIMITER $$
CREATE TRIGGER `trg_user_story_status_log` AFTER UPDATE ON `user_stories` FOR EACH ROW BEGIN
    IF OLD.status != NEW.status THEN
        INSERT INTO activity_logs (user_id, project_group_id, entity_type, entity_id, action, old_value, new_value, ip_address)
        VALUES (
            NEW.created_by,
            NEW.project_group_id,
            'user_story',
            NEW.id,
            'status_change',
            JSON_OBJECT('status', OLD.status, 'title', OLD.title),
            JSON_OBJECT('status', NEW.status, 'title', NEW.title),
            '127.0.0.1'
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_member_contributions`
-- (See below for the actual view)
--
CREATE TABLE `v_member_contributions` (
`group_id` int(11)
,`group_name` varchar(100)
,`user_id` int(11)
,`full_name` varchar(100)
,`student_code` varchar(20)
,`tasks_assigned` bigint(21)
,`tasks_completed` bigint(21)
,`total_hours` decimal(27,2)
,`avg_technical_score` decimal(14,4)
,`avg_collaboration_score` decimal(14,4)
,`avg_communication_score` decimal(14,4)
,`avg_contribution_score` decimal(14,4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_sprint_progress`
-- (See below for the actual view)
--
CREATE TABLE `v_sprint_progress` (
`sprint_id` int(11)
,`sprint_name` varchar(100)
,`sprint_number` int(11)
,`status` enum('planning','active','completed','cancelled')
,`start_date` date
,`end_date` date
,`total_stories` bigint(21)
,`completed_stories` bigint(21)
,`total_points` decimal(32,0)
,`completed_points` decimal(32,0)
,`capacity` int(11)
,`days_remaining` int(7)
,`completion_percentage` decimal(38,2)
);

-- --------------------------------------------------------

--
-- Structure for view `v_member_contributions`
--
DROP TABLE IF EXISTS `v_member_contributions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_member_contributions`  AS SELECT `g`.`id` AS `group_id`, `g`.`group_name` AS `group_name`, `u`.`id` AS `user_id`, `u`.`full_name` AS `full_name`, `u`.`student_code` AS `student_code`, count(distinct `ta`.`task_id`) AS `tasks_assigned`, count(distinct case when `ta`.`status` = 'completed' then `ta`.`task_id` end) AS `tasks_completed`, sum(case when `ta`.`status` = 'completed' then `t`.`actual_hours` else 0 end) AS `total_hours`, avg(`pr`.`technical_score`) AS `avg_technical_score`, avg(`pr`.`collaboration_score`) AS `avg_collaboration_score`, avg(`pr`.`communication_score`) AS `avg_communication_score`, avg(`pr`.`contribution_score`) AS `avg_contribution_score` FROM (((((`project_groups` `g` join `group_members` `gm` on(`g`.`id` = `gm`.`group_id`)) join `users` `u` on(`gm`.`user_id` = `u`.`id`)) left join `task_assignments` `ta` on(`u`.`id` = `ta`.`user_id`)) left join `tasks` `t` on(`ta`.`task_id` = `t`.`id`)) left join `peer_reviews` `pr` on(`u`.`id` = `pr`.`reviewee_id`)) GROUP BY `g`.`id`, `g`.`group_name`, `u`.`id`, `u`.`full_name`, `u`.`student_code` ;

-- --------------------------------------------------------

--
-- Structure for view `v_sprint_progress`
--
DROP TABLE IF EXISTS `v_sprint_progress`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_sprint_progress`  AS SELECT `s`.`id` AS `sprint_id`, `s`.`sprint_name` AS `sprint_name`, `s`.`sprint_number` AS `sprint_number`, `s`.`status` AS `status`, `s`.`start_date` AS `start_date`, `s`.`end_date` AS `end_date`, count(distinct `us`.`id`) AS `total_stories`, count(distinct case when `us`.`status` = 'done' then `us`.`id` end) AS `completed_stories`, sum(coalesce(`us`.`story_points`,0)) AS `total_points`, sum(case when `us`.`status` = 'done' then coalesce(`us`.`story_points`,0) else 0 end) AS `completed_points`, `s`.`capacity` AS `capacity`, to_days(`s`.`end_date`) - to_days(curdate()) AS `days_remaining`, round(sum(case when `us`.`status` = 'done' then coalesce(`us`.`story_points`,0) else 0 end) / nullif(sum(coalesce(`us`.`story_points`,0)),0) * 100,2) AS `completion_percentage` FROM (`sprints` `s` left join `user_stories` `us` on(`s`.`id` = `us`.`sprint_id`)) GROUP BY `s`.`id`, `s`.`sprint_name`, `s`.`sprint_number`, `s`.`status`, `s`.`start_date`, `s`.`end_date`, `s`.`capacity` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_group` (`project_group_id`),
  ADD KEY `idx_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `idx_log_group_created` (`project_group_id`,`created_at`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD KEY `idx_course_code` (`course_code`),
  ADD KEY `idx_instructor` (`instructor_id`),
  ADD KEY `idx_semester` (`semester`,`year`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_group_user` (`group_id`,`user_id`),
  ADD KEY `idx_group` (`group_id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `peer_reviews`
--
ALTER TABLE `peer_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_review` (`sprint_id`,`reviewer_id`,`reviewee_id`),
  ADD KEY `idx_sprint` (`sprint_id`),
  ADD KEY `idx_reviewer` (`reviewer_id`),
  ADD KEY `idx_reviewee` (`reviewee_id`);

--
-- Indexes for table `project_groups`
--
ALTER TABLE `project_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_code` (`group_code`),
  ADD KEY `idx_course` (`course_id`),
  ADD KEY `idx_group_code` (`group_code`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `sprints`
--
ALTER TABLE `sprints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_group` (`project_group_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_dates` (`start_date`,`end_date`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_story` (`user_story_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_task_story_status` (`user_story_id`,`status`);

--
-- Indexes for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_by` (`assigned_by`),
  ADD KEY `idx_task` (`task_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_assignment_user_status` (`user_id`,`status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_student_code` (`student_code`);

--
-- Indexes for table `user_stories`
--
ALTER TABLE `user_stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_group` (`project_group_id`),
  ADD KEY `idx_sprint` (`sprint_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_priority` (`priority`),
  ADD KEY `idx_user_story_sprint_status` (`sprint_id`,`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID log', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID học phần', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `group_members`
--
ALTER TABLE `group_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID membership', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peer_reviews`
--
ALTER TABLE `peer_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID đánh giá';

--
-- AUTO_INCREMENT for table `project_groups`
--
ALTER TABLE `project_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID nhóm', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sprints`
--
ALTER TABLE `sprints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID sprint', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID task', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task_assignments`
--
ALTER TABLE `task_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID phân công', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID người dùng', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_stories`
--
ALTER TABLE `user_stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID user story', AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_logs_ibfk_2` FOREIGN KEY (`project_group_id`) REFERENCES `project_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `project_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peer_reviews`
--
ALTER TABLE `peer_reviews`
  ADD CONSTRAINT `peer_reviews_ibfk_1` FOREIGN KEY (`sprint_id`) REFERENCES `sprints` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peer_reviews_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peer_reviews_ibfk_3` FOREIGN KEY (`reviewee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_groups`
--
ALTER TABLE `project_groups`
  ADD CONSTRAINT `project_groups_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sprints`
--
ALTER TABLE `sprints`
  ADD CONSTRAINT `sprints_ibfk_1` FOREIGN KEY (`project_group_id`) REFERENCES `project_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_story_id`) REFERENCES `user_stories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD CONSTRAINT `task_assignments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_assignments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_assignments_ibfk_3` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_stories`
--
ALTER TABLE `user_stories`
  ADD CONSTRAINT `user_stories_ibfk_1` FOREIGN KEY (`project_group_id`) REFERENCES `project_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_stories_ibfk_2` FOREIGN KEY (`sprint_id`) REFERENCES `sprints` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_stories_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
