<?php
$array = file("pw.txt", FILE_IGNORE_NEW_LINES);
$url = 'https://login.microsoftonline.com/consumers/oauth2/v2.0/token';
$data = array('client_id' => 'a93f99a5-3d78-41f3-812e-9d1130cab3c9', 'scope' => 'user.read Files.Read Files.Read.All offline_access', 'grant_type' => 'refresh_token', 'redirect_uri' => 'https://tool.piagno.ch/groove/callback.php', 'refresh_token' => $_GET["code"], 'client_secret' => $array[0]);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { echo "ERROR"; }
echo $result
?>