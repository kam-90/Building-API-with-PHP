<?php
$url = "https://www.google.com";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_exec($ch);
curl_close($ch);
?>
