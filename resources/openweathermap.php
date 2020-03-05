<?php

class OpenweathermapResource{

	function __construct($access_key){
		$this->__access_key = $access_key;
	}

	function get_data($city){
		$response = file_get_contents("https://api.openweathermap.org/data/2.5/weather?APPID=$this->__access_key&q=$city");
		return $response;
	}

	function get_json($data){
	$data = json_decode($data, true);
		$json_data = array(
			"temp"=> (int)(($data['main']['temp'])-273),
			"desc"=> $data['weather'][0]['description']
		);
	return $json_data;
	}
}

?>