<!DOCTYPE html>
<html>
  <head>
    <title>tw3w 地圖</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 70%;
      }
    </style>
  </head>
  <body>


 <div id="map"></div>
 <div style="text-align:center;background-color:white"><input style="font-size:20px;border-width:0px;border:none" type="text" id="w3w" disabled/></div>
 <div class="row" style="text-align:center;background-color:white">
     <form method="GET" action="./">
       <div class="col-md-4">line BOT QRCORD:
<img src="./img/w3wlinebot.png" width="200"></div>
       <div class="col-md-2"></div>
          <div class="col-md-2">
        <select class="form-control" id="s">
          <option value="tw3w">中文w3w</option>
          <option value="w3w">英文w3w</option>
          <option value="address">地址</option>
          <option value="latlng">經緯度</option>
        </select>
        </div>
        <div class="col-md-3">
         <input class="form-control"  style="font-size:20px;" id="w" type="text" name="tw3w" autocomplete="off" placeholder="高雄.應用.科大"/>
        </div>
        <div class="col-md-1">
         <button class="btn btn-link"  style="font-size:20px" type="submit" id="search"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
      </div>
     </form>
 </div>
 
 <script type="text/javascript" src="https://googledrive.com/host/0B6dtn0LtYgFgUUFtMzhOWHpyQ0k/jquery-1.7.2.min.js"></script>
 <script src="js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8o5wP-Bilwuwke0L1mns-gMXu98If-vc&callback=initMap"
        async defer></script>
 <script>
var Data=[];
var map;
var infowindow;
var lat2="22.6511869";
var lng2="120.3289648";
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 22.6511869, lng: 120.3289648},
    zoom: 15
  });
 // getJson("https://phplinebot-ouvek-kostiva.c9users.io/api.php?tw3w=高雄.應用.科大");
};

 $('#s').change(function(){
    $("#w").attr("name",$('select#s option:selected').val()); 
    if($('select#s option:selected').val()=="tw3w") {
      $("#w").attr("placeholder","高雄.應用.科大");
    }
    if($('select#s option:selected').val()=="w3w") {
      $("#w").attr("placeholder","shell.coarser.trickle");
    }
    if($('select#s option:selected').val()=="address") {
      $("#w").attr("placeholder","高雄市三民區建工路415號");
    }
    if($('select#s option:selected').val()=="latlng") {
      $("#w").attr("placeholder","22.6511869,120.3289648");
    }
 });

 
  
  
function getJson(api) {
	
		console.log(api);
		$.get( api, function( data ) {
    if(data=="null"){
      $("#w3w").val("輸入地址錯誤");
     return;
      
    }
});
		$.getJSON( api,function( json ) {
		  
        Data=[json.lat,json.lng,json.w3w,json.zhtw];
        
        getMarker(Data);
        });
        
};


//取得GET的參數
$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
  
});

if($.getUrlVar("tw3w")!=null){
  getJson("https://phplinebot-ouvek-kostiva.c9users.io/api.php?tw3w="+$.getUrlVar("tw3w"));
};
if($.getUrlVar("address")!=null){
  getJson("https://phplinebot-ouvek-kostiva.c9users.io/api.php?address="+$.getUrlVar("address"));

};
if($.getUrlVar("w3w")!=null){
  getJson("https://phplinebot-ouvek-kostiva.c9users.io/api.php?w3w="+$.getUrlVar("w3w"));

};
if($.getUrlVar("latlng")!=null){
  getJson("https://phplinebot-ouvek-kostiva.c9users.io/api.php?latlng="+$.getUrlVar("latlng"));

};

function getMarker(Data)
 	{	
 	
		var mark = new google.maps.Marker({
position: new google.maps.LatLng(Data[0],Data[1]),
title:Data[2],
map:map //要顯示標記的地圖
});
google.maps.event.addListener(mark, 'click', function() {
    	if (!infowindow) {
   			 infowindow = new google.maps.InfoWindow();
   			 }
    // Setting the content of the InfoWindow
    infowindow.setContent("tw3w:"+Data[3]+"<br>w3w:"+Data[2]+"<br>lat:"+Data[0]+"<br>lng:"+Data[1]);
    // Tying the InfoWindow to the marker
    infowindow.open(map, mark);
    });
console.log(Data[0]+","+Data[1]);
map.panTo(new google.maps.LatLng(Data[0],Data[1]));
map.setZoom(15);
$("#w3w").val(Data[3]);
 	}

    </script>
 
  </body>
</html>