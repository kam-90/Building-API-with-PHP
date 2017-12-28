<?php
$url = 'http://localhost/API2/products/4';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPGET, true);
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