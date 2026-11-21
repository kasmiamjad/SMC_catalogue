<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

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
    $body = substr($responseWithHeader, $header_size);

    curl_close($curl);

    // Do not log the request/response here: they contain the password and the Odoo session cookie.

    $responseData = json_decode($body, true);

    // A successful login response should not have a top-level 'error' object.
    if ($httpcode == 200 && isset($responseData['result']) && !isset($responseData['error'])) {
        // New session id on login to prevent session fixation.
        session_regenerate_id(true);
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
            $errorMessage = $responseData['error']['message'];
            if (isset($responseData['error']['data']['message'])) {
                $errorMessage .= " - " . $responseData['error']['data']['message'];
            }
        }
        header('Location: login.php?error=' . urlencode($errorMessage));
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>