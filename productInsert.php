<?php
$data=array(
		'product_name' =>'PS4',
		'price' => 3000,
		'quantity' => 8,
		'seller' =>'XYZ '
);
//$data = URLify( $data, TRUE );
//echo $data;
$DT=http_build_query($data);
//echo($DT);
$url = 'http://localhost/API2/products';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS,$DT);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_json = curl_exec($ch);
echo $response_json;
curl_close($ch);

function URLify( $arr, $encode = FALSE ) {

    $fields_string = '';
    foreach( $arr as $key => $value ) {
        if ( $encode ) {
      $key = urlencode( $key );
            $value = urlencode( $value );
        }
        $fields_string .= $key . '=' . $value . '&';
    }
    $fields_string = substr( $fields_string, 0, (strlen($fields_string)-1) );

    return $fields_string;

}


?>