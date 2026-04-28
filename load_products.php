<?php
$jsonFilePath = 'data.json';

if (file_exists($jsonFilePath)) {
    $jsonContent = file_get_contents($jsonFilePath);
    $data = json_decode($jsonContent, true);
    $requestedCategory = isset($_GET['category']) ? $_GET['category'] : '';
    
    $filteredProducts = [];
    //print_r($data);
    if ($requestedCategory && isset($data['result']['payload']['product_stock_details'])) {
        //echo "T".$requestedCategory;
        foreach ($data['result']['payload']['product_stock_details'] as $product) {
            if ($product['product_category'] === $requestedCategory) {
                $filteredProducts[] = $product;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($filteredProducts);
} else {
    echo json_encode(['error' => 'Data file not found.']);
}
?>
