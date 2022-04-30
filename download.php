<?php
$values = file_get_contents('php://input');
$id = explode(':',$values)[0];
$key = explode(':',$values)[1];
$url = "https://graph.microsoft.com/v1.0/me/drive/items/".$id."/content";
$options = array(
    'http' => array(
        'header'  => "Authorization: Bearer ".$key."\r\n",
        'method'  => 'GET',
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { echo "ERROR"; }
echo $http_response_header[14];
