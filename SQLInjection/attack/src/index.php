<?php
// index.php
require_once 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop - セキュリティ学習用ECサイト</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">
    <!-- ヘッダー -->
    <header class="bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center h-16">
                <div class="text-xl font-bold mr-8">MyShop</div>
                <div class="flex-1 flex items-center">
                    <form action="search.php" method="GET" class="flex-1 max-w-2xl relative">
                        <input type="text" 
                            name="q" 
                            placeholder="検索" 
                            class="w-full px-4 py-2 rounded text-gray-900">
                        <button type="submit" class="absolute right-2 top-2 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="11" cy="11" r="8"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="flex items-center space-x-6 ml-8">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="flex items-center">
                            <span class="mr-4">こんにちは、<?php echo htmlspecialchars($_SESSION['username']); ?>さん</span>
                            <a href="logout.php" class="hover:text-gray-300">ログアウト</a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <a href="cart.php" class="relative hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="9" cy="21" r="1"/>
                            <circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <?php if(isset($_SESSION['cart_count']) && $_SESSION['cart_count'] > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            <?php echo $_SESSION['cart_count']; ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex gap-8">
            <!-- サイドバー -->
            <div class="w-64 flex-shrink-0">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="font-bold text-lg mb-4">カテゴリー</h2>
                    <ul class="space-y-2">
                        <?php
                        $categories = [
                            "家電・カメラ",
                            "パソコン・オフィス用品",
                            "ホーム＆キッチン",
                            "ファッション",
                            "本・コミック",
                            "おもちゃ・ホビー",
                            "スポーツ・アウトドア",
                        ];
                        foreach($categories as $category): ?>
                            <li class="hover:text-blue-600 cursor-pointer">
                                <a href="category.php?name=<?php echo urlencode($category); ?>">
                                    <?php echo htmlspecialchars($category); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- 商品グリッド -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    // 商品データを取得（実際にはデータベースから取得）
                    $products = [
                        ["id" => 1, "name" => "ワイヤレスイヤホン", "price" => "¥15,800", "rating" => 4.5],
                        ["id" => 2, "name" => "スマートウォッチ", "price" => "¥32,800", "rating" => 4.2],
                        ["id" => 3, "name" => "ノートPC", "price" => "¥128,000", "rating" => 4.8],
                        ["id" => 4, "name" => "デジタルカメラ", "price" => "¥78,900", "rating" => 4.6],
                        ["id" => 5, "name" => "Bluetoothスピーカー", "price" => "¥12,800", "rating" => 4.3],
                        ["id" => 6, "name" => "タブレット", "price" => "¥45,800", "rating" => 4.7],
                    ];

                    foreach($products as $product): ?>
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                            <img src="/images/placeholder.jpg" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="w-full h-48 object-cover rounded-t-lg">
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </h3>
                                <div class="text-xl text-gray-900 mb-2">
                                    <?php echo htmlspecialchars($product['price']); ?>
                                </div>
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400">
                                        <?php
                                        $rating = $product['rating'];
                                        for($i = 1; $i <= 5; $i++) {
                                            echo $i <= floor($rating) ? "★" : "☆";
                                        }
                                        ?>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">
                                        <?php echo $product['rating']; ?>
                                    </span>
                                </div>
                                <form action="cart.php" method="POST" class="mt-4">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" name="add_to_cart" 
                                            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition-colors">
                                        カートに追加
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>