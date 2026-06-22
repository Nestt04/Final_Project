# STUDENT PROJECT - PBL TRACKER

## Thông tin đề tài

**Môn học:** INS3064 - MULTIMEDIA DESIGN AND WEB DEVELOPMENT  
**Trường:** Trường Quốc tế ISchool - ĐHQGHN  
**Năm:** 2026  
**Đề tài:** Quản lý Học tập Theo Dự án – Project-Based Learning Tracker

---

## Thông tin nhóm

| STT | Họ và tên | MSSV | Phần phụ trách |
|-----|-----------|------|----------------|
| 1 | Lê Văn Thuận | 22070984 | users, courses, project_groups |
| 2 | Bùi Minh Hiếu | 22070905 | sprints, user_stories, tasks |
| 3 | Trần Hoàng Minh | 22070343 | task_assignments, activity_logs, peer_reviews |

---

## 🎯 Mô tả hệ thống

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

## 🗄️ Cấu trúc Database (9 bảng)

### Lê Văn Thuận - User & Course Management

1. **users** - Quản lý tài khoản người dùng
2. **courses** - Quản lý học phần áp dụng PBL
3. **project_groups** - Quản lý nhóm dự án

### Bùi Minh Hiếu - Sprint & Task Management

4. **sprints** - Quản lý các sprint của nhóm
5. **user_stories** - Quản lý user story trong backlog
6. **tasks** - Quản lý task chi tiết thuộc user story

### Trần Hoàng Minh - Assignment & Tracking

7. **task_assignments** - Phân công task cho thành viên
8. **activity_logs** - Log mọi thao tác thay đổi trạng thái
9. **peer_reviews** - Đánh giá chéo giữa các thành viên

---

## 🏗️ Kiến trúc hệ thống

### Design Patterns áp dụng

- **Singleton Pattern** - Database connection
- **Repository Pattern** - Data access layer
- **MVC Pattern** - Model-View-Controller architecture
- **Factory Pattern** - Repository factory

### Công nghệ sử dụng

- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+ / MariaDB 10.2+
- **Frontend:** Bootstrap 5, Font Awesome 6
- **JavaScript:** Vanilla JS
- **Web Server:** Apache / Nginx

---

## 🚀 Hướng dẫn cài đặt

### 1. Yêu cầu hệ thống

- PHP >= 7.4
- MySQL >= 5.7 hoặc MariaDB >= 10.2
- Apache/Nginx với mod_rewrite
- XAMPP/WAMP/MAMP (khuyến nghị cho Windows)

### 2. Cài đặt project

**Bước 1: Copy project vào thư mục web server**

```bash
# Với XAMPP
Copy thư mục studentproject vào: C:\xampp\htdocs\

# Kết quả:
C:\xampp\htdocs\studentproject\
```

**Bước 2: Tạo database**

```sql
-- Mở phpMyAdmin hoặc MySQL CLI
CREATE DATABASE pbl_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**Bước 3: Import database schema**

```bash
# Sử dụng MySQL CLI
mysql -u root -p pbl_tracker < database/schema.sql

# Hoặc import qua phpMyAdmin:
# 1. Truy cập http://localhost/phpmyadmin
# 2. Chọn database pbl_tracker
# 3. Tab "Import"
# 4. Chọn file database/schema.sql
# 5. Click "Go"
```

**Bước 4: Cấu hình kết nối database**

Mở file `config/database.php` và chỉnh sửa:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'pbl_tracker');
define('DB_USER', 'root');
define('DB_PASS', '');  // Mật khẩu MySQL của bạn
```

**Bước 5: Khởi động Apache và MySQL**

- Mở XAMPP Control Panel
- Start Apache và MySQL

**Bước 6: Truy cập hệ thống**

Mở trình duyệt và truy cập:

```
http://localhost/studentproject/public/
```

---

## 🔐 Tài khoản mặc định

### Admin
- **Email:** admin@ischool.vnu.edu.vn
- **Password:** password

### Giảng viên
- **Email:** lecturer@ischool.vnu.edu.vn
- **Password:** password

### Sinh viên (Lê Văn Thuận)
- **Email:** 22070984@vnu.edu.vn
- **Password:** password

### Sinh viên (Bùi Minh Hiếu)
- **Email:** 22070905@vnu.edu.vn
- **Password:** password

### Sinh viên (Trần Hoàng Minh)
- **Email:** 22070343@vnu.edu.vn
- **Password:** password

---

## 📁 Cấu trúc thư mục

```
studentproject/
├── config/
│   ├── database.php          # Cấu hình database
│   └── constants.php         # Hằng số hệ thống
├── src/
│   ├── Controllers/          # Controllers (MVC)
│   │   └── AuthController.php
│   ├── Core/                 # Core classes
│   │   ├── Database.php      # Singleton Database
│   │   └── Session.php       # Session management
│   └── Repositories/         # Repository Pattern
│       ├── BaseRepository.php
│       └── UserRepository.php
├── public/                   # Public files
│   ├── index.php            # Entry point
│   ├── .htaccess            # Apache config
│   └── css/
│       └── style.css        # Main stylesheet
├── views/                    # Views (Templates)
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   └── dashboard/
│       ├── student.php
│       ├── lecturer.php
│       └── admin.php
├── database/
│   └── schema.sql           # Database schema
├── .gitignore
└── README.md                # File này
```

---

## ✨ Tính năng nâng cao (Điểm cộng)

### ✅ MVC Pattern (+10%)
- Tách biệt rõ ràng Model, View, Controller
- Routing system chuyên nghiệp

### ✅ Singleton Pattern (+5%)
- Database connection singleton
- Tối ưu hiệu năng

### ✅ Repository Pattern (+10%)
- Tách logic truy vấn khỏi controller
- Dễ bảo trì và test

### ✅ AJAX CRUD (+15%)
- Thao tác CRUD không reload trang
- Real-time update status

### ✅ RBAC - Role Based Access Control (+10%)
- 3 vai trò: Student, Lecturer, Admin
- Middleware kiểm tra quyền truy cập

### ✅ Responsive UI (+5%)
- Bootstrap 5
- Mobile-friendly
- Modern design

### ✅ Activity Logging (+5%)
- Ghi log mọi thao tác
- Audit trail đầy đủ

### ✅ Contribution Analytics (+10%)
- Tính điểm đóng góp tự động
- Biểu đồ thống kê

### ✅ Sprint Planning Tools (+10%)
- Capacity planning
- Velocity tracking

### ✅ Peer Review System (+10%)
- Đánh giá chéo
- Anonymous option
- Aggregated scores

**Tổng điểm cộng dự kiến: +90%**

---

## 🔧 Xử lý sự cố

### Lỗi "Database Connection Failed"
- Kiểm tra MySQL đã khởi động chưa
- Kiểm tra thông tin trong `config/database.php`
- Đảm bảo database `pbl_tracker` đã được tạo

### Lỗi "404 Not Found"
- Kiểm tra file `.htaccess` trong thư mục `public/`
- Đảm bảo Apache mod_rewrite đã được bật
- Kiểm tra đường dẫn truy cập: `http://localhost/studentproject/public/`

### Lỗi "Permission Denied"
- Trên Linux/Mac: `chmod -R 755 studentproject/`
- Đảm bảo Apache có quyền đọc thư mục

### Không thể đăng nhập
- Import lại database từ `database/schema.sql`
- Xóa cache trình duyệt
- Kiểm tra PHP session đang hoạt động

---

## 📞 Liên hệ & Hỗ trợ

Mọi thắc mắc xin liên hệ:

- **Lê Văn Thuận:** 22070984@vnu.edu.vn
- **Bùi Minh Hiếu:** 22070905@vnu.edu.vn
- **Trần Hoàng Minh:** 22070343@vnu.edu.vn

---

## 📝 License

Dự án này được phát triển cho mục đích học tập tại Trường Quốc tế ISchool - ĐHQGHN.

---

## 🎓 Tài liệu tham khảo

- [PHP Official Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.0/)
- [Design Patterns in PHP](https://refactoring.guru/design-patterns/php)
- [Scrum Guide](https://scrumguides.org/)

---

**© 2026 Team Alpha - Trường Quốc tế ISchool - ĐHQGHN**
