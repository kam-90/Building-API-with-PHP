<?php

$data=array(
		'product_name' =>'Bugatti',
		'price' => 45000,
		'quantity' => 5,
		'seller' =>'BMW SHOWROOM.'
);
$url = 'http://localhost/API2/products/9';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_json = curl_exec($ch);
echo $response_json;
curl_close($ch);
//$response=json_decode($response_json, true);

?>
