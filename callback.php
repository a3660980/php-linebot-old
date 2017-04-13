<?php

require "gmap.php";
require "w3w.php";
require "w3w2zhtw.php";
/*接收Line聊天室資料*/
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$to = $jsonObj->{"result"}[0]->{"content"}->{"from"};
$text = $jsonObj->{"result"}[0]->{"content"}->{"text"};
$type = $jsonObj->{"result"}[0]->{"content"}->{"contentType"};
$location=$jsonObj->{"result"}[0]->{"content"}->{"location"};
$originalContentUrl = json_encode($jsonObj->{'result'}[0]->{'content'});
/*接收Line聊天室資料*/

switch ($type) {
    case '1': //輸入的訊息是文字
        switch (substr($text,0,1)) {
            case '#': //地址開頭
                $data_arr = geocode(substr($text,1));
                $lat=$data_arr[0];
                $lng=$data_arr[1];
                $addr=$data_arr[2];
                $json = (array)json_decode("[".w3w($lat,$lng)."]",true);
                $w3w=$json[0]["words"];
                if($w3w!="") {
                    $response_format = ['contentType'=>1,
                        "toType"=>2,
                        "text"=>"英文:\n@".$w3w."\nhttp://w3w.co/$w3w"."\n中文:\n@".w2zh($w3w,$lat,$lng)."\nhttp://tw3w.xyz/?tw3w=".w2zh($w3w,$lat,$lng)
                        ];
                }else{
                    $response_format = ['contentType'=>1,
                        "toType"=>2,
                        "text"=>"地址不存在"
                        ];    
                    }
                break;
            case '@': //w3w
                if( preg_match("/^[a-z]+$/",substr($text,1,1)) > 0){ 
                    
                    $w3wjson = getLatLng(substr($text,1));
                    $json=(array)json_decode("[".$w3wjson."]",true);
                    $lng=$json[0]["geometry"]["lng"];
                    $lat=$json[0]["geometry"]["lat"];
                    $add_arr = getAddr($lat,$lng);
                    
                    if(!is_null($add_arr)){
                        $address = $add_arr[2].", ".$add_arr[0].", ".$add_arr[1];
                       $address=$add_arr[3];
                        $response_format = ['contentType'=>7,
                            "toType"=>2,
                            "text"=>"$address",
                            "location"=>
                            [
                                "title"=>"位置訊息\n$address",
                                "latitude"=>"$lat",
                                "longitude"=>"$lng"
                            ]
                        ];
                        w2zh(substr($text,1),$lat,$lng);
                    }else{
                        $response_format = ['contentType'=>1,
                            "toType"=>2,
                            "text"=>"w3w型態為三字中間由句點分隔，且不可有空格\n例：@whizzed.ranted.rips"
                            ];    
                        }
                }else{
                    $latlng = zh2w(substr($text,1));
                    $add_arr = getAddr($latlng['lat'],$latlng['lng']);
                    
                    if(!is_null($add_arr)){
                        $address = $add_arr[2].", ".$add_arr[0].", ".$add_arr[1];
                        $address=$add_arr[3];
                        $response_format = ['contentType'=>7,
                            "toType"=>2,
                            "text"=>"$address",
                            "location"=>
                            [
                                "title"=>"位置訊息\n$address",
                                "latitude"=>$latlng['lat'],
                                "longitude"=>$latlng['lng']
                            ]
                        ];
                    }else{
                        $response_format = ['contentType'=>1,
                            "toType"=>2,
                            "text"=>"中文w3w型態為三字詞中間由句點分隔，且不可有空格\n例：@whizzed.ranted.rips\n@高雄.應用.科大"
                            ];    
                        }
                    
                }
                break;
            default:
                $response_format = ['contentType'=>1,
                        "toType"=>1,
                        "text"=>"您輸入了：$text\n".
                        "\n".
                        "查詢 @w3w 位置 請在地址前加#\n".
                        "[地址]\n".
                        "#高雄市三民區建工路415號\n".
                        "[地點]\n".
                        "#高應大\n".
                        "\n".
                        "查詢 位置 請在 w3w 前加 @\n".
                        "@whizzed.ranted.rips"
                        ];
                break;
        }
        break;
    case '2': //輸入的訊息是圖片
        $response_format = ['contentType'=>2,
                "toType"=>1,
                "originalContentUrl"=>"http://i.imgur.com/FmbuPNe.jpg",
                "previewImageUrl"=>"http://i.imgur.com/FmbuPNe.jpg"
                ];
        break;
    case '3': //輸入的訊息是影片
        $response_format = ['contentType'=>2,
                "toType"=>1,
                "originalContentUrl"=>"http://i.imgur.com/FmbuPNe.jpg",
                "previewImageUrl"=>"http://i.imgur.com/FmbuPNe.jpg"
                ];
    case '4': //輸入的訊息是語音
        $response_format = ['contentType'=>2,
                "toType"=>1,
                "originalContentUrl"=>"http://i.imgur.com/FmbuPNe.jpg",
                "previewImageUrl"=>"http://i.imgur.com/FmbuPNe.jpg"
                ];
    case '7': //輸入的訊息是位置
        $lat=$location->{"latitude"};
        $lng=$location->{"longitude"};
        $json = (array)json_decode("[".w3w($lat,$lng)."]",true);
        $w3w=$json[0]["words"];
        if($w3w!="") {
            $response_format = ['contentType'=>1,
                "toType"=>1,
                "text"=>"英文:\n@".$w3w."\nhttp://w3w.co/$w3w"."\n中文:\n@".w2zh($w3w,$lat,$lng)."\nhttp://tw3w.xyz/?tw3w=".w2zh($w3w,$lat,$lng)
                        ];
        }else{
            $response_format = ['contentType'=>1,
                "toType"=>1,
                "text"=>"地址不存在"
                ];    
            }
        break;
    case '8': //輸入的訊息是貼圖
        $response_format = [
                "contentType"=>2,
                "toType"=>1,
                "originalContentUrl"=>"http://i.imgur.com/FmbuPNe.jpg",
                "previewImageUrl"=>"http://i.imgur.com/FmbuPNe.jpg"
                ];
        break;
    case '10': //輸入的訊息是聯絡資訊
        $response_format = ['contentType'=>2,
                "toType"=>1,
                "originalContentUrl"=>"http://i.imgur.com/FmbuPNe.jpg",
                "previewImageUrl"=>"http://i.imgur.com/FmbuPNe.jpg"
                ];
        break;
}

// toChannel與eventType 不變。
$post_data = ["to"=>[$to],
    "toChannel"=>"1383378250",
    "eventType"=>"138311608800106203",
    "content"=>$response_format];

/* 取資料 */
$ch = curl_init("https://trialbot-api.line.me/v1/events");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'X-Line-ChannelID: 	1464179820',
    'X-Line-ChannelSecret: 	d5941c7b159f4022044fe504ea969a95',
    'X-Line-Trusted-User-With-ACL: 	u549bcf05c569514203950b755154b353'
    ));
$result = curl_exec($ch);
echo $result;
curl_close($ch);
/* 取資料 */