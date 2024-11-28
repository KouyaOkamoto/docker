<?php
require_once 'config.php';
session_start();

// セッションを破棄
session_destroy();

// ログインページにリダイレクト
header('Location: login.php');
exit;
?>