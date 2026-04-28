<?php
// Set header to JSON
header('Content-Type: application/json');

// Assuming your JSON data is in 'data.json'
$jsonFilePath = 'data.json';
$categoryCounts = [];

if (file_exists($jsonFilePath)) {
    $jsonContent = file_get_contents($jsonFilePath);
    $data = json_decode($jsonContent, true);

    if ($data !== null && isset($data['result']['payload']['product_stock_details'])) {
        // Count products by category
        foreach ($data['result']['payload']['product_stock_details'] as $product) {
            $category = $product['product_category'];
            
            if (!isset($categoryCounts[$category])) {
                $categoryCounts[$category] = 0;
            }
            
            $categoryCounts[$category]++;
        }
    }
}

// Return the counts as JSON
echo json_encode($categoryCounts);
?>