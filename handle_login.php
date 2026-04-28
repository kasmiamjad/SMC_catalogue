<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $apiUrl = 'https://smc.ardhalfan.com/web/session/authenticate';
    $requestData = json_encode([
        'params' => [
            'db' => 'Production',
            'login' => $username,
            'password' => $password
        ]
    ]);

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $requestData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($requestData)
    ]);
    // Include the header in the output
    curl_setopt($curl, CURLOPT_HEADER, true);


    $responseWithHeader = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $header = substr($responseWithHeader, 0, $header_size);
    $body = substr($responseWithHeader, $header_size);

    curl_close($curl);

    // Log the full response for debugging
    $log = "Time: " . date('Y-m-d H:i:s') . "\n";
    $log .= "Request Body: " . $requestData . "\n";
    $log .= "HTTP Code: " . $httpcode . "\n";
    $log .= "Response Header: " . $header . "\n";
    $log .= "Response Body: " . $body . "\n";
    $log .= "---------------------------------" . "\n";
    file_put_contents('log.txt', $log, FILE_APPEND);


    $responseData = json_decode($body, true);

    // A successful login response should not have a top-level 'error' object.
    if ($httpcode == 200 && isset($responseData['result']) && !isset($responseData['error'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        if (isset($responseData['result']['session_id'])) {
            $_SESSION['session_id'] = $responseData['result']['session_id'];
        }

        header('Location: index.php');
        exit;
    } else {
        $errorMessage = 'Invalid username or password';
        if (isset($responseData['error']) && isset($responseData['error']['message'])) {
            $errorMessage = $responseData['error']['message'] . " - " . $responseData['error']['data']['message'];
        }
        header('Location: login.php?error=' . urlencode($errorMessage));
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>