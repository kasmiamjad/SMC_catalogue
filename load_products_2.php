<?php
$jsonFilePath = 'data.json';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Number of products per page
$start = ($page - 1) * $limit;
$requestedCategory = isset($_GET['category']) ? $_GET['category'] : '';
$productsToShow = [];

if (file_exists($jsonFilePath)) {
    $jsonContent = file_get_contents($jsonFilePath);
    $data = json_decode($jsonContent, true);
    $allProducts = [];

    if ($requestedCategory && isset($data['result']['payload']['product_stock_details'])) {
        foreach ($data['result']['payload']['product_stock_details'] as $product) {
            if ($product['product_category'] === $requestedCategory) {
                $allProducts[] = $product;
            }
        }
    }

    // Get the total number of products for pagination
    $totalProducts = count($allProducts);
    $productsToShow = array_slice($allProducts, $start, $limit);

    // Prepare the response with pagination details
    $response = [
        'totalProducts' => $totalProducts,
        'products' => $productsToShow,
        'totalPages' => ceil($totalProducts / $limit),
        'currentPage' => $page
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Data file not found.']);
}
?>
