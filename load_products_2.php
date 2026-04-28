<?php
/**
 * Product loader with pagination, category, and parent filtering support.
 */

require_once __DIR__ . '/lib/category_helper.php';

$jsonFilePath = 'data.json';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 200; // Default to a large batch for smooth browsing
$start = ($page - 1) * $limit;

$requestedCategory = isset($_GET['category']) ? $_GET['category'] : '';
$requestedParent = isset($_GET['parent']) ? $_GET['parent'] : '';

$response = [
    'totalProducts' => 0,
    'products' => [],
    'totalPages' => 0,
    'currentPage' => $page
];

if (file_exists($jsonFilePath)) {
    $jsonContent = file_get_contents($jsonFilePath);
    $data = json_decode($jsonContent, true);

    if (isset($data['result']['payload']['product_stock_details'])) {
        $allProducts = $data['result']['payload']['product_stock_details'];
        $filteredProducts = [];

        // 1. Filtering logic
        if ($requestedCategory) {
            // Priority 1: Specific category filter
            foreach ($allProducts as $product) {
                if ($product['product_category'] === $requestedCategory) {
                    $filteredProducts[] = $product;
                }
            }
        } elseif ($requestedParent) {
            // Priority 2: Parent group filter
            if ($requestedParent === 'ALL') {
                $filteredProducts = $allProducts;
            } else {
                // Get all unique categories in the data for lookup
                $uniqueCategories = array_unique(array_column($allProducts, 'product_category'));
                $children = get_children_of($requestedParent, $uniqueCategories);
                
                foreach ($allProducts as $product) {
                    if (in_array($product['product_category'], $children)) {
                        $filteredProducts[] = $product;
                    }
                }
            }
        } else {
            // Priority 3: No filter -> return all
            $filteredProducts = $allProducts;
        }

        // 2. Pagination
        $totalProducts = count($filteredProducts);
        $productsToShow = array_slice($filteredProducts, $start, $limit);

        $response = [
            'totalProducts' => $totalProducts,
            'products' => $productsToShow,
            'totalPages' => ceil($totalProducts / $limit),
            'currentPage' => $page
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header('Content-Type: application/json', true, 404);
    echo json_encode(['error' => 'Data file not found.']);
}
?>
