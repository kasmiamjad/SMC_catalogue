<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://saudimotors.syntrack.app//web/get_external_product_stock_details',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'{
"params": {
}
}
',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: session_id=8150c17e22442bd50e323bc7fa15605b75e3514b'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

// Check if the response is not empty
if (!empty($response)) {
    // Save the JSON response to a file called data.json
    if (file_put_contents('data.json', $response) === false) {
        echo 'Error saving data to file.';
    } else {
        echo 'Data saved to data.json successfully.';
    }

    // Decode the JSON data into a PHP array
    $data = json_decode($response, true);

    // Check if decoding was successful
    if ($data !== null) {
        // Access the product stock details array
        $productStockDetails = $data['result']['payload']['product_stock_details'];
        // Optional: Additional code to work with $productStockDetails
    } else {
        // Handle JSON decoding error
        echo 'Error decoding JSON data.';
    }
} else {
    // Handle case when no response is received
    echo 'No response received from the API.';
}
?>
