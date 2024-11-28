<?php
// config.php

// セッション設定（セッション開始前に設定する必要がある）
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

// データベース設定
define('DB_HOST', 'db');
define('DB_USER', 'app_user');
define('DB_PASS', 'app_password');
define('DB_NAME', 'security_training');

// 脆弱性のあるデータベース接続（学習用）
function getVulnerableConnection() {
    return new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}

// セキュアなデータベース接続（比較用）
function getSecureConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die("Connection failed");
    }
    return $conn;
}

// エラー表示設定（学習用に詳細なエラーを表示）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>