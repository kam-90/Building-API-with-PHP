<?php
$url = 'http://localhost/API2/products/5';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_json = curl_exec($ch);
echo $response_json;
curl_close($ch);
//$response=json_decode($response_json, true);

?>