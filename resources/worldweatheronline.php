<?php

class WorldweatheronlineResource{

	function __construct($access_key){
		$this->__access_key = $access_key;
	}

	function get_data($city){
		$response = file_get_contents("https://api.worldweatheronline.com/premium/v1/weather.ashx?format=json&key=$this->__access_key&q=$city");
		return $response;
	}

	function get_json($data){
	$data = json_decode($data, true);
		$json_data = array(
			"temp"=> $data['data']['current_condition'][0]['temp_C'],
			"desc"=> $data['data']['current_condition'][0]['weatherDesc'][0]['value']
		);
	return $json_data;
	}
}
?>