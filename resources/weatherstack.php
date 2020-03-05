<?php


class WeatherstackResource{

	function __construct($access_key){
		$this->__access_key = $access_key;
	}

	function get_data($city){
		$response = file_get_contents("https://api.weatherstack.com/current?access_key=$this->__access_key&q=$city");
		return $response;
	}

	function get_json($data){
	$data = json_decode($data, true);
		$json_data = array(
			'temp'=> data['current']['temperature'],
			'desc'=> data['current']['weather_descriptions'][0]
		);
	return $json_data;
	}
}
?>