<?php
// search.php
require_once 'config.php';

function searchProducts($query) {
    $conn = getVulnerableConnection();
    
    // 脆弱なSQLクエリ（SQLインジェクション可能）
    $sql = "SELECT * FROM products WHERE name LIKE '$query' OR description LIKE '$query'";
    
    $result = $conn->query($sql);
    $products = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    } else {
        // エラー情報の露出（セキュリティ上問題あり）
        die("Error: " . $conn->error);
    }
    
    return $products;
}

$searchResults = [];
if (isset($_GET['q'])) {
    $searchResults = searchProducts($_GET['q']);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果 - MyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">
    <!-- ヘッダーは省略（index.phpと同じ） -->
    
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">検索結果: "<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($searchResults as $product): ?>
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="text-xl font-bold mt-2">¥<?php echo number_format($product['price'], 2); ?></p>
                </div>
            <?php endforeach; ?>
            
            <?php if(empty($searchResults)): ?>
                <p class="col-span-3 text-center text-gray-600">検索結果が見つかりませんでした。</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>