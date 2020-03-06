<?php

require_once('config.php');
require_once('cashedata.php');
require_once('resources/openweathermap.php');
require_once('resources/weatherstack.php');
require_once('resources/worldweatheronline.php');


class HttpProcessor{
		
	function __construct(){
		$this->_resources = array(
			'weatherstack' => new WeatherstackResource(WEATHERSTACK_ACCESS_KEY),
			'openweathermap' => new OpenweathermapResource(OPENWEATHERMAP_ACCESS_KEY),
			'worldweatheronline' => new WorldweatheronlineResource(WORLDWEATHERONLINE_ACCESS_KEY),
		);
		$this->operator = new CacheData();
	}

	function do_GET(){
		$city = $_GET['city'];
		$resource = $_GET['resource'];
		if($this->operator->check_cache($resource.$city)){
			$data_weather = $this->operator->kesh_dict;
		}else{
			$data_weather = $this->get_data_weather($resource, $city);
		}
		$description = $data_weather['desc'];
		$temperature = $data_weather['temp'];
		$this->operator->$kesh_dict = array(
			$city.$resource => array(	
					'temp'=> $temperature,
					'desc'=> $description,
					),
			'time'=> time()
			);

		echo ' City is	'.$city;echo PHP_EOL;
		echo ' temp = '.$temperature;echo PHP_EOL;
		echo ' desc -- '.$description;echo PHP_EOL;
	}

	function get_data_weather($resource, $city){
		$data_weather = $this->_resources[$resource];
		$get_data = $data_weather->get_data($city);
		return $data_weather->get_json($get_data);
	}

}



$start = new HttpProcessor();
$start->do_GET();
 ?>