<?php
require_once 'config.php';
session_start();

$error_message = '';
$debug_sql = ''; // デバッグ用SQLを保存する変数

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!empty($username) && !empty($password)) {
        // 脆弱性のある実装（SQL Injection可能）
        $conn = getVulnerableConnection();
        
        // 危険なSQL文（SQLインジェクションの脆弱性あり）
        $hashed_password = md5($password);  // パスワードを先にハッシュ化
        $sql = "SELECT id, username, password, role FROM users 
                WHERE username = '$username' AND password = '$hashed_password' ";  // 最後にスペースを追加
                
        $debug_sql = $sql; // デバッグ用にSQLを保存
                
        try {
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                $conn->close();
                header('Location: index.php');
                exit;
            } else {
                $error_message = 'ログインに失敗しました。<br>入力内容を確認してください。';
            }
        } catch (mysqli_sql_exception $e) {
            $error_message = 'SQLエラー: ' . $e->getMessage();
        }
        
        $conn->close();
    } else {
        $error_message = 'ユーザー名とパスワードを入力してください。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - MyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    <?php if ($debug_sql): ?>
    <!-- Debug SQL: <?php echo $debug_sql; ?> -->
    <?php endif; ?>
    
    <div class="max-w-md w-full mx-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">MyShop</h2>
            <p class="text-gray-600 mt-2">セキュリティ学習用ログインページ</p>
            <p class="text-red-600 mt-2">※このページはSQLインジェクション攻撃の学習用です</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-8">
            <?php if ($error_message): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="mb-6">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">
                        ユーザー名
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           required>
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                        パスワード
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                           required>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                        ログイン
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600">アカウントをお持ちでない方は</p>
                <a href="register.php" class="text-blue-600 hover:text-blue-800 font-semibold">
                    新規登録
                </a>
            </div>
        </div>
    </div>
</body>
</html>