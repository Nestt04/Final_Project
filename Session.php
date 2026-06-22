<?php
namespace App\Core;

/**
 * Session Class
 * 
 * Quản lý session và authentication
 * 
 * @author Lê Văn Thuận (22070984)
 */
class Session
{
    /**
     * Start session
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name(SESSION_NAME);
            session_start();
            
            // Regenerate session ID periodically for security
            if (!isset($_SESSION['created'])) {
                $_SESSION['created'] = time();
            } else if (time() - $_SESSION['created'] > 1800) {
                session_regenerate_id(true);
                $_SESSION['created'] = time();
            }
        }
    }

    /**
     * Set session data
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session data
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if session key exists
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Delete session key
     */
    public static function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destroy session
     */
    public static function destroy(): void
    {
        session_destroy();
        $_SESSION = [];
    }

    /**
     * Set flash message
     */
    public static function flash(string $key, $value): void
    {
        $_SESSION['flash'][$key] = $value;
    }

    /**
     * Get and delete flash message
     */
    public static function getFlash(string $key, $default = null)
    {
        $value = $_SESSION['flash'][$key] ?? $default;
        unset($_SESSION['flash'][$key]);
        return $value;
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
    }

    /**
     * Get logged in user ID
     */
    public static function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get logged in user email
     */
    public static function getUserEmail(): ?string
    {
        return $_SESSION['user_email'] ?? null;
    }

    /**
     * Get logged in user role
     */
    public static function getUserRole(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    /**
     * Get logged in user full name
     */
    public static function getUserFullName(): ?string
    {
        return $_SESSION['user_full_name'] ?? null;
    }

    /**
     * Set user session after login
     */
    public static function setUser(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_full_name'] = $user['full_name'];
        $_SESSION['user_avatar'] = $user['avatar'] ?? null;
    }

    /**
     * Clear user session (logout)
     */
    public static function clearUser(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_full_name']);
        unset($_SESSION['user_avatar']);
    }

    /**
     * Check if user has specific role
     */
    public static function hasRole(string $role): bool
    {
        return self::getUserRole() === $role;
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin(): bool
    {
        return self::hasRole(ROLE_ADMIN);
    }

    /**
     * Check if user is lecturer
     */
    public static function isLecturer(): bool
    {
        return self::hasRole(ROLE_LECTURER);
    }

    /**
     * Check if user is student
     */
    public static function isStudent(): bool
    {
        return self::hasRole(ROLE_STUDENT);
    }

    /**
     * Generate CSRF token
     */
    public static function generateCsrfToken(): string
    {
        if (!self::has('csrf_token')) {
            self::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return self::get('csrf_token');
    }

    /**
     * Verify CSRF token
     */
    public static function verifyCsrfToken(string $token): bool
    {
        return self::has('csrf_token') && hash_equals(self::get('csrf_token'), $token);
    }
}
