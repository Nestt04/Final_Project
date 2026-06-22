<?php
namespace App\Controllers;

use App\Core\Session;
use App\Repositories\UserRepository;

/**
 * Authentication Controller
 * 
 * Xử lý đăng nhập, đăng xuất, đăng ký
 * 
 * @author Lê Văn Thuận (22070984)
 */
class AuthController
{
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    /**
     * Show login page
     */
    public function showLogin(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirectToDashboard();
            return;
        }

        require VIEW_PATH . '/auth/login.php';
    }

    /**
     * Process login
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        // Validate input
        if (empty($email) || empty($password)) {
            Session::flash('error', 'Vui lòng nhập đầy đủ email và mật khẩu');
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // Verify credentials
        $user = $this->userRepo->verifyPassword($email, $password);

        if (!$user) {
            Session::flash('error', 'Email hoặc mật khẩu không đúng');
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // Set session
        Session::setUser($user);

        // Remember me (optional)
        if ($remember) {
            // Implement remember me logic here
        }

        Session::flash('success', 'Đăng nhập thành công!');
        $this->redirectToDashboard();
    }

    /**
     * Show registration page
     */
    public function showRegister(): void
    {
        if (Session::isLoggedIn()) {
            $this->redirectToDashboard();
            return;
        }

        require VIEW_PATH . '/auth/register.php';
    }

    /**
     * Process registration
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'register');
            exit;
        }

        // Get form data
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $fullName = trim($_POST['full_name'] ?? '');
        $role = $_POST['role'] ?? 'student';
        $studentCode = trim($_POST['student_code'] ?? '');

        // Validate input
        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email không được để trống';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ';
        } elseif (!preg_match('/@(ischool\.vnu\.edu\.vn|vnu\.edu\.vn)$/', $email)) {
            $errors[] = 'Email phải thuộc domain @ischool.vnu.edu.vn hoặc @vnu.edu.vn';
        } elseif ($this->userRepo->emailExists($email)) {
            $errors[] = 'Email đã được sử dụng';
        }

        if (empty($fullName)) {
            $errors[] = 'Họ tên không được để trống';
        }

        if (empty($password)) {
            $errors[] = 'Mật khẩu không được để trống';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
        } elseif ($password !== $passwordConfirm) {
            $errors[] = 'Mật khẩu xác nhận không khớp';
        }

        if ($role === 'student' && empty($studentCode)) {
            $errors[] = 'Mã sinh viên không được để trống';
        }

        if (!empty($errors)) {
            Session::flash('error', implode('<br>', $errors));
            header('Location: ' . BASE_URL . 'register');
            exit;
        }

        // Create user
        try {
            $userData = [
                'email' => $email,
                'password' => $password,
                'full_name' => $fullName,
                'role' => $role,
                'student_code' => $role === 'student' ? $studentCode : null,
                'is_active' => 1
            ];

            $userId = $this->userRepo->createUser($userData);

            if ($userId) {
                Session::flash('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
                header('Location: ' . BASE_URL . 'login');
                exit;
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Đã xảy ra lỗi khi đăng ký. Vui lòng thử lại.');
            header('Location: ' . BASE_URL . 'register');
            exit;
        }
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        Session::clearUser();
        Session::flash('success', 'Đăng xuất thành công');
        header('Location: ' . BASE_URL . 'login');
        exit;
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    private function redirectToDashboard(): void
    {
        $role = Session::getUserRole();
        
        switch ($role) {
            case ROLE_ADMIN:
                header('Location: ' . BASE_URL . 'admin/dashboard');
                break;
            case ROLE_LECTURER:
                header('Location: ' . BASE_URL . 'lecturer/dashboard');
                break;
            case ROLE_STUDENT:
                header('Location: ' . BASE_URL . 'student/dashboard');
                break;
            default:
                header('Location: ' . BASE_URL);
                break;
        }
        exit;
    }

    /**
     * Check if user is authenticated (middleware)
     */
    public static function requireAuth(): void
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Vui lòng đăng nhập để tiếp tục');
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    /**
     * Check if user has required role (middleware)
     */
    public static function requireRole(string $role): void
    {
        self::requireAuth();
        
        if (!Session::hasRole($role)) {
            Session::flash('error', 'Bạn không có quyền truy cập trang này');
            header('Location: ' . BASE_URL);
            exit;
        }
    }
}
