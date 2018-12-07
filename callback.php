<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
<?php
$array = file("pw.txt", FILE_IGNORE_NEW_LINES);
$url = 'https://login.microsoftonline.com/consumers/oauth2/v2.0/token';
$data = array('client_id' => 'a93f99a5-3d78-41f3-812e-9d1130cab3c9', 'scope' => 'user.read Files.Read Files.Read.All offline_access', 'grant_type' => 'authorization_code', 'redirect_uri' => 'https://tool.piagno.ch/groove/callback.php', 'code' => $_GET["code"], 'client_secret' => $array[0]);

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

?>
		<script>
			var rawData = '<?php echo $result; ?>'
			var data = JSON.parse(rawData)
			var expires = new Date()
			expires.setSeconds(expires.getSeconds() + data["expires_in"] - 1000)
			localStorage.setItem('ms_access_token',data["access_token"])
			localStorage.setItem('ms_refresh_token',data["refresh_token"])
			localStorage.setItem('ms_expires_in',expires)
			window.location.assign('/groove')
		</script>
	</body>
</html>