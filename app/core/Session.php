<?php

class Session {
    // Start the session
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Set session data
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    // Get session data
    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    // Destroy the session
    public static function destroy() {
        session_start();
        session_unset();
        session_destroy();
    }

    // Check if user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
