<?php
function loginAndGetSessionCookie() {
    $loginUrl = 'https://saudimotors.syntrack.app/web/session/mobile_login?db=Production';
    $loginData = json_encode(array(
        "params" => array(
            "login" => "api_user",
            "password" => "Api@11589",
            "device_name" => "DELL VOSTRO",
            "imei_no" => "12312323232"
        )
    ));

    $curl = curl_init($loginUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $loginData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json'
    ));
    curl_setopt($curl, CURLOPT_HEADER, true);

    $response = curl_exec($curl);
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);

    if (curl_errno($curl)) {
        die("Login request failed: " . curl_error($curl));
    }

    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches);
    $cookies = array();
    foreach ($matches[1] as $item) {
        parse_str($item, $cookie);
        $cookies = array_merge($cookies, $cookie);
    }

    $sessionCookie = '';
    foreach ($cookies as $key => $val) {
        $sessionCookie .= $key . '=' . $val . '; ';
    }

    curl_close($curl);

    return $sessionCookie;
}

function fetchData($sessionCookie) {
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
    'Cookie: ' . $sessionCookie
  ),
));



    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        die("Data fetch request failed: " . curl_error($curl));
    }

    curl_close($curl);

    return $response;
}

$sessionCookie = loginAndGetSessionCookie();
$data = fetchData($sessionCookie);

if (!file_put_contents('data.json', $data)) {
    echo "Error saving data to file.";
} else {
    echo "Data successfully saved to data";
}
?>
