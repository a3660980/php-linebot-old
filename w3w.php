<?php
function w3w($lat,$lng){
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.what3words.com/v2/reverse?coords=$lat,$lng&display=full&format=json&key=NWKHA5K6",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      return $response;
    }
}

function getLatLng($words){
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.what3words.com/v2/forward?addr=$words&display=full&format=json&key=NWKHA5K6",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      return $response;
    }
}