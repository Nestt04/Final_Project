# PROJECT-BASED LEARNING TRACKER

## Thông tin đề tài

**Môn học:** INS3064 - MULTIMEDIA DESIGN AND WEB DEVELOPMENT  
**Trường:** Trường Quốc tế ISchool - ĐHQGHN  
**Năm:** 2026  
**Đề tài:** Quản lý Học tập Theo Dự án – Project-Based Learning Tracker

---

## Thông tin nhóm

| STT | Họ và tên | MSSV | Phần phụ trách |
|-----|-----------|------|----------------|
| 1 | [BLê Văn Thuận] | [22070984] | users, courses, project_groups |
| 2 | [Bùi Minh Hiếu] | [22070905] | sprints, user_stories, tasks |
| 3 | [Trần Hoàng Minh] | [22070343] | task_assignments, activity_logs, peer_reviews |

---

## Mô tả hệ thống

### Bối cảnh
Nhiều học phần tại ISchool tổ chức theo mô hình project-based có sprint, backlog, demo, peer review. Quản lý thủ công bằng Excel và nhóm Facebook rất rời rạc.

### Mục tiêu
Xây dựng hệ thống web quản lý backlog, user story, sprint, phân công task cho từng thành viên nhóm; giảng viên theo dõi tiến độ thực tế.

### Chức năng chính

#### 1. Sprint & Backlog Logic
- Tạo sprint, kéo user story vào sprint
- Tính tổng story points
- Cảnh báo nếu vượt capacity nhóm

#### 2. Activity Log
- Ghi log toàn bộ hành động (ai tạo task, ai chuyển trạng thái, thời điểm nào)
- Phục vụ audit khi đánh giá công bằng

#### 3. Contribution Score
- Backend tính "điểm đóng góp" từ log
- Số task hoàn thành, story points, lần review
- Xuất report giúp GV chấm điểm cá nhân trong project nhóm

---

## Cấu trúc Database (9 bảng)

### Lê Văn Thuận - User & Course Management

#### 1. users
Quản lý tài khoản người dùng (Sinh viên, Giảng viên)

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID người dùng |
| email | VARCHAR(100) UNIQUE | Email đăng nhập |
| password | VARCHAR(255) | Mật khẩu (hashed) |
| full_name | VARCHAR(100) | Họ tên đầy đủ |
| role | ENUM('student','lecturer','admin') | Vai trò |
| avatar | VARCHAR(255) | Đường dẫn ảnh đại diện |
| created_at | TIMESTAMP | Thời gian tạo |
| updated_at | TIMESTAMP | Thời gian cập nhật |

#### 2. courses
Quản lý học phần áp dụng PBL

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID học phần |
| course_code | VARCHAR(20) UNIQUE | Mã học phần |
| course_name | VARCHAR(200) | Tên học phần |
| instructor_id | INT FK(users.id) | Giảng viên phụ trách |
| semester | VARCHAR(20) | Học kỳ |
| year | INT | Năm học |
| description | TEXT | Mô tả học phần |
| max_group_size | INT | Số thành viên tối đa/nhóm |
| created_at | TIMESTAMP | Thời gian tạo |
| updated_at | TIMESTAMP | Thời gian cập nhật |

#### 3. project_groups
Quản lý nhóm dự án trong từng học phần

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID nhóm |
| course_id | INT FK(courses.id) | Học phần |
| group_name | VARCHAR(100) | Tên nhóm |
| group_code | VARCHAR(20) UNIQUE | Mã nhóm |
| project_topic | VARCHAR(255) | Chủ đề dự án |
| max_capacity | INT | Số thành viên tối đa |
| status | ENUM('active','completed','archived') | Trạng thái |
| created_at | TIMESTAMP | Thời gian tạo |
| updated_at | TIMESTAMP | Thời gian cập nhật |

### Bùi Minh Hiếu - Sprint & Task Management

#### 4. sprints
Quản lý các sprint của nhóm

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID sprint |
| project_group_id | INT FK(project_groups.id) | Nhóm dự án |
| sprint_name | VARCHAR(100) | Tên sprint |
| sprint_number | INT | Số thứ tự sprint |
| start_date | DATE | Ngày bắt đầu |
| end_date | DATE | Ngày kết thúc |
| goal | TEXT | Mục tiêu sprint |
| capacity | INT | Capacity (story points) |
| status | ENUM('planning','active','completed','cancelled') | Trạng thái |
| created_at | TIMESTAMP | Thời gian tạo |
| updated_at | TIMESTAMP | Thời gian cập nhật |

#### 5. user_stories
Quản lý user story trong backlog

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID user story |
| project_group_id | INT FK(project_groups.id) | Nhóm dự án |
| sprint_id | INT FK(sprints.id) NULL | Sprint (NULL = backlog) |
| title | VARCHAR(255) | Tiêu đề |
| description | TEXT | Mô tả chi tiết |
| acceptance_criteria | TEXT | Tiêu chí chấp nhận |
| story_points | INT | Điểm ước lượng |
| priority | ENUM('low','medium','high','critical') | Độ ưu tiên |
| status | ENUM('backlog','todo','in_progress','done') | Trạng thái |
| created_by | INT FK(users.id) | Người tạo |
| created_at | TIMESTAMP | Thời gian tạo |
| updated_at | TIMESTAMP | Thời gian cập nhật |

#### 6. tasks
Quản lý task chi tiết thuộc user story

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID task |
| user_story_id | INT FK(user_stories.id) | User story |
| title | VARCHAR(255) | Tiêu đề task |
| description | TEXT | Mô tả chi tiết |
| estimated_hours | DECIMAL(5,2) | Giờ ước lượng |
| actual_hours | DECIMAL(5,2) | Giờ thực tế |
| status | ENUM('todo','in_progress','review','done') | Trạng thái |
| priority | ENUM('low','medium','high') | Độ ưu tiên |
| created_at | TIMESTAMP | Thời gian tạo |
| updated_at | TIMESTAMP | Thời gian cập nhật |

### Trần Hoàng Minh - Assignment & Tracking

#### 7. task_assignments
Phân công task cho thành viên

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID phân công |
| task_id | INT FK(tasks.id) | Task |
| user_id | INT FK(users.id) | Thành viên được giao |
| assigned_by | INT FK(users.id) | Người phân công |
| assigned_at | TIMESTAMP | Thời gian phân công |
| started_at | TIMESTAMP NULL | Thời gian bắt đầu |
| completed_at | TIMESTAMP NULL | Thời gian hoàn thành |
| status | ENUM('assigned','working','completed','cancelled') | Trạng thái |
| notes | TEXT | Ghi chú |

#### 8. activity_logs
Log mọi thao tác thay đổi trạng thái

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID log |
| user_id | INT FK(users.id) | Người thực hiện |
| project_group_id | INT FK(project_groups.id) | Nhóm dự án |
| entity_type | VARCHAR(50) | Loại entity (sprint, task, story) |
| entity_id | INT | ID của entity |
| action | VARCHAR(50) | Hành động (create, update, delete) |
| old_value | TEXT | Giá trị cũ (JSON) |
| new_value | TEXT | Giá trị mới (JSON) |
| ip_address | VARCHAR(45) | IP thực hiện |
| created_at | TIMESTAMP | Thời gian |

#### 9. peer_reviews
Đánh giá chéo giữa các thành viên

| Field | Type | Description |
|-------|------|-------------|
| id | INT PK AUTO_INCREMENT | ID đánh giá |
| sprint_id | INT FK(sprints.id) | Sprint |
| reviewer_id | INT FK(users.id) | Người đánh giá |
| reviewee_id | INT FK(users.id) | Người được đánh giá |
| technical_score | INT | Điểm kỹ thuật (1-10) |
| collaboration_score | INT | Điểm hợp tác (1-10) |
| communication_score | INT | Điểm giao tiếp (1-10) |
| contribution_score | INT | Điểm đóng góp (1-10) |
| comment | TEXT | Nhận xét |
| is_anonymous | BOOLEAN | Ẩn danh hay không |
| created_at | TIMESTAMP | Thời gian đánh giá |

---

## Kiến trúc hệ thống

### 1. Design Patterns áp dụng

#### Singleton Pattern
- **DatabaseConnection**: Đảm bảo chỉ có 1 kết nối database duy nhất

#### Repository Pattern
- **UserRepository**: Quản lý truy vấn users
- **CourseRepository**: Quản lý truy vấn courses
- **ProjectGroupRepository**: Quản lý truy vấn project_groups
- **SprintRepository**: Quản lý truy vấn sprints
- **UserStoryRepository**: Quản lý truy vấn user_stories
- **TaskRepository**: Quản lý truy vấn tasks
- **TaskAssignmentRepository**: Quản lý truy vấn task_assignments
- **ActivityLogRepository**: Quản lý truy vấn activity_logs
- **PeerReviewRepository**: Quản lý truy vấn peer_reviews

#### Factory Pattern
- **RepositoryFactory**: Tạo các repository instance

#### MVC Pattern
- **Model**: Các entity class và repository
- **View**: Template files (PHP + HTML)
- **Controller**: Xử lý logic nghiệp vụ


## Hướng dẫn cài đặt

### 1. Clone/Download project

```bash
# Giải nén vào thư mục web server
# Ví dụ: C:\xampp\htdocs\pbl-tracker
```

### 2. Cấu hình database

```bash
# Tạo database
CREATE DATABASE pbl_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Import schema
mysql -u root -p pbl_tracker < database/schema.sql
```

### 3. Cấu hình kết nối

Chỉnh sửa file `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'studentproject');
define('DB_USER', 'root');
define('DB_PASS', '1234');
```

### 4. Truy cập hệ thống

```
http://localhost/studentproject/public/
```
## Phân công công việc chi tiết

### Lê Văn Thuận: User & Course Management

**Bảng phụ trách:**
1. users
2. courses
3. project_groups

**Chức năng:**
- ✅ Authentication (Login/Logout/Register)
- ✅ User CRUD (Create, Read, Update, Delete)
- ✅ Course CRUD
- ✅ Project Group CRUD
- ✅ User profile management
- ✅ Role-based dashboard

**Controllers:**
- AuthController.php
- UserController.php (nếu tách riêng)
- CourseController.php
- ProjectGroupController.php

**Repositories:**
- UserRepository.php
- CourseRepository.php
- ProjectGroupRepository.php

### Bùi Minh Hiếu: Sprint & Task Management

**Bảng phụ trách:**
1. sprints
2. user_stories
3. tasks

**Chức năng:**
- ✅ Sprint CRUD
- ✅ Sprint planning (capacity, velocity)
- ✅ User Story CRUD
- ✅ Backlog management
- ✅ Drag & drop story to sprint
- ✅ Task CRUD
- ✅ Kanban board
- ✅ Story points calculation

**Controllers:**
- SprintController.php
- UserStoryController.php
- TaskController.php

**Repositories:**
- SprintRepository.php
- UserStoryRepository.php
- TaskRepository.php

### Trần Hoàng Minh: Assignment & Tracking

**Bảng phụ trách:**
1. task_assignments
2. activity_logs
3. peer_reviews

**Chức năng:**
- ✅ Task Assignment CRUD
- ✅ Assign task to members
- ✅ Track task progress
- ✅ Activity logging (automatic)
- ✅ Activity log viewer
- ✅ Peer Review CRUD
- ✅ Review submission
- ✅ Review report & analytics
- ✅ Contribution score calculation

**Controllers:**
- TaskAssignmentController.php
- ActivityLogController.php
- PeerReviewController.php

**Repositories:**
- TaskAssignmentRepository.php
- ActivityLogRepository.php
- PeerReviewRepository.php

---

## Testing

### Test Cases

#### Authentication
- ✅ Login với email/password đúng
- ✅ Login với thông tin sai
- ✅ Logout
- ✅ Session timeout
- ✅ Remember me

#### User Management (Lê Văn Thuận)
- ✅ Tạo user mới (validation)
- ✅ Xem danh sách users
- ✅ Cập nhật thông tin user
- ✅ Xóa user (soft delete)
- ✅ Tìm kiếm user

#### Course Management (Thuận)
- ✅ Tạo course mới
- ✅ Xem danh sách courses
- ✅ Cập nhật course
- ✅ Xóa course
- ✅ Assign instructor

#### Project Group Management (Thuận)
- ✅ Tạo nhóm dự án
- ✅ Thêm/xóa thành viên
- ✅ Kiểm tra max capacity
- ✅ Xem thông tin nhóm

#### Sprint Management (Bùi Minh Hiếu)
- ✅ Tạo sprint
- ✅ Kiểm tra date validation
- ✅ Cập nhật sprint status
- ✅ Xóa sprint

#### User Story Management (Hiếu)
- ✅ Tạo user story
- ✅ Move story to sprint
- ✅ Kiểm tra capacity
- ✅ Update story status

#### Task Management (Hiếu)
- ✅ Tạo task
- ✅ Update task status
- ✅ Track estimated vs actual hours

#### Task Assignment (Trần Hoàng Minh)
- ✅ Assign task to member
- ✅ Kiểm tra member trong nhóm
- ✅ Update assignment status

#### Activity Log (Minh)
- ✅ Auto log khi CRUD
- ✅ Xem lịch sử thay đổi
- ✅ Filter logs

#### Peer Review (Minh)
- ✅ Submit review
- ✅ Anonymous review
- ✅ View aggregated scores
- ✅ Generate report

---

---
## License
Dự án này được phát triển cho mục đích học tập tại Trường Quốc tế ISchool - ĐHQGHN.
---
## Contact
- Email: 22070905@vnu.edu.vn
- GitHub: https://github.com/

