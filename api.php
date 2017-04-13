<?php
header('Access-Control-Allow-Origin: *');
require "gmap.php";
require "w3w.php";
require "w3w2zhtw.php";
    //中文w3w
     if(isset($_GET['tw3w'])) {
        $tw3w=$_GET['tw3w'];
        $array=zh2w($tw3w);
        echo json_encode($array);
     }
     //英文w3w
     if(isset($_GET['w3w'])){
        $w3w=$_GET['w3w'];
        $w3wjson=getlatlng($w3w);
        $json=(array)json_decode("[".$w3wjson."]",true);
        $lng=$json[0]["geometry"]["lng"];
        $lat=$json[0]["geometry"]["lat"];
        $array=zh2w(w2zh($w3w,$lat,$lng));
        echo json_encode($array);
     }
     //地址
    if(isset($_GET['address'])){
        $address=$_GET['address'];
        $data_arr = geocode($address);
        $lat=$data_arr[0];
        $lng=$data_arr[1];
        $addr=$data_arr[2];
        $json = (array)json_decode("[".w3w($lat,$lng)."]",true);
        $w3w=$json[0]["words"];
                
        $w3wjson=getlatlng($w3w);
        $json=(array)json_decode("[".$w3wjson."]",true);
        $lng=$json[0]["geometry"]["lng"];
        $lat=$json[0]["geometry"]["lat"];
        $array=zh2w(w2zh($w3w,$lat,$lng));
        echo json_encode($array);
    }
    //經緯度
     if(isset($_GET['latlng'])) {
        $latlng=$_GET['latlng'];
        $arr_latlng = explode(",",$latlng);
        $lat=$arr_latlng[0];
        $lng=$arr_latlng[1];
        
        $add_arr=getAddr($lat,$lng);
        $address = $add_arr[2].", ".$add_arr[0].", ".$add_arr[1];
        $data_arr = geocode($address);
        $lat=$data_arr[0];
        $lng=$data_arr[1];
        $addr=$data_arr[2];
        $json = (array)json_decode("[".w3w($lat,$lng)."]",true);
        $w3w=$json[0]["words"];
               
        $w3wjson=getlatlng($w3w);
        $json=(array)json_decode("[".$w3wjson."]",true);
        $lng=$json[0]["geometry"]["lng"];
        $lat=$json[0]["geometry"]["lat"];
        $array=zh2w(w2zh($w3w,$lat,$lng));
        echo json_encode($array);

     }