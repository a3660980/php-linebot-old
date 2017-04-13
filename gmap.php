<?php
function geocode($address){

	// url encode the address
	$address = urlencode($address);
	
	// google map geocode api url
	$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=AIzaSyDGs4Hn8lhLgd87Wx4bfAaqNA6BLNQanws";

	// get the json response
	$resp_json = file_get_contents($url);
	
	// decode the json
	$resp = json_decode($resp_json, true);

	// response status will be 'OK', if able to geocode given address 
	if($resp['status']=='OK'){

		// get the important data
		$lati = $resp['results'][0]['geometry']['location']['lat'];
		$longi = $resp['results'][0]['geometry']['location']['lng'];
		$formatted_address = $resp['results'][0]['formatted_address'];
		
		// verify if data is complete
		if($lati && $longi && $formatted_address){
		
			// put the data in the array
			$data_arr = array();			
			
			array_push(
				$data_arr, 
					$lati, 
					$longi, 
					$formatted_address
				);
			
			return $data_arr;
			
		}else{
			return false;
		}
		
	}else{
		return false;
	}
}

function getAddr($lat,$lng){
	
	$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&sensor=true";
    $data = @file_get_contents($url);
    $jsondata = json_decode($data,true);
    if(is_array($jsondata) && $jsondata['status'] == "OK")
    {
          $city = $jsondata['results']['0']['address_components']['2']['long_name'];
          $country = $jsondata['results']['0']['address_components']['5']['long_name'];
          $street = $jsondata['results']['0']['address_components']['1']['long_name'];
          $address=$jsondata['results']['0']['formatted_address'];
          $data_arr = array();			
			
		  array_push(
			$data_arr, 
			    $city, 
				$country, 
				$street,
				$address
			);
		    
		  return $data_arr;
    }else{
        return null;
    }
    
}