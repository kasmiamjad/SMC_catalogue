<?php
header('Content-Type: application/json');

require_once __DIR__ . '/lib/category_helper.php';

$jsonFilePath = __DIR__ . '/data.json';

if (!file_exists($jsonFilePath)) {
    http_response_code(500);
    echo json_encode(['error' => 'data unavailable']);
    exit;
}

$data = json_decode(file_get_contents($jsonFilePath), true);
if ($data === null || !isset($data['result']['payload']['product_stock_details'])) {
    http_response_code(500);
    echo json_encode(['error' => 'data malformed']);
    exit;
}

$childCounts = [];   // exact category name => count
$parentCounts = [];  // parent name => sum of children counts
$total = 0;

foreach ($data['result']['payload']['product_stock_details'] as $product) {
    $cat = $product['product_category'] ?? null;
    if (!$cat) continue;

    $total++;

    if (!isset($childCounts[$cat])) $childCounts[$cat] = 0;
    $childCounts[$cat]++;

    $parent = get_parent_for($cat);
    if ($parent) {
        if (!isset($parentCounts[$parent])) $parentCounts[$parent] = 0;
        $parentCounts[$parent]++;
    }
}

// Ensure "ALL" parent reflects the true total of all items in catalogue
$parentCounts['ALL'] = $total;

echo json_encode([
    'children' => $childCounts,
    'parents'  => $parentCounts,
    'total'    => $total
]);