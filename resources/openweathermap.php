<?php

class OpenweathermapResource{

	private $path_parameters = [];


	public function __construct($access_key){
		$this->__access_key = $access_key;
		$this->path_parameters = array(
			'wind' => array('main', 'temp', 0, 'temp_C'),
			'pres' => array('main', 'pressure'),
			'desc' => array('weather', 0, 'description'),
			'temp' => array('main', 'temp'),
		);
	}


	public function get_data($city){
		$response = file_get_contents("https://api.openweathermap.org/data/2.5/weather?APPID=$this->__access_key&q=$city");
		return $response;
	}


	public function get_json($data){
	$data = json_decode($data, true);
		$json_data = array(
			"temp"=> (int)(($data['main']['temp'])-273),
			"desc"=> $data['weather'][0]['description']
		);
	return $json_data;
	}


	public function get_json2($data, $type_parameters){
	$data = json_decode($data, true);
	$json_data = [];
	foreach($type_parameters as $value){
		$json_data[$value] = $this->get_single_parameter($this->path_parameters[$value]);
		echo '</br>'.'ECHO';
		print_r($json_data[$value]);
		echo '</br>';
	}
	return $json_data;
	}


	private function get_single_parameter($arr_parameters){
		foreach($arr_parameters as $el){
			$temp = $data[$el];
			$data[$el] = $temp;
		}
		return $temp;
	}
}

?>