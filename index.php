<?php
require_once('config.php');
require_once('cache.php');
require_once('count.php');
require_once('resources/openweathermap.php');
require_once('resources/weatherstack.php');
require_once('resources/worldweatheronline.php');


class HttpServer{
		
	private $operator;
	private $_resources = [];

	public function __construct(){
		$this->operator = new Cache(10);
		$this->_resources = array(
			'weatherstack' => new WeatherstackResource(WEATHERSTACK_ACCESS_KEY),
			'openweathermap' => new OpenweathermapResource(OPENWEATHERMAP_ACCESS_KEY),
			'worldweatheronline' => new WorldweatheronlineResource(WORLDWEATHERONLINE_ACCESS_KEY),
		);
	}

	public function start(){
		readfile('form.html');
		$city = $_GET['city'];
		$resource = $_GET['resources'];
		$data_weather = $this->operator->get($resource.$city);
		if(!$data_weather)
		{
			$data_weather = $this->get_data_weather($resource, $city);
			$this->operator->set($resource.$city, $data_weather);
		}
		echo $this->display_weather($data_weather);
	}


	private function display_weather($data_weather)
	{
		$description = $data_weather['desc'];
		if(!($description == ''))
		{
			return json_encode($data_weather);
		}
		return 'wrong city';
	}


	private function get_data_weather($resource, $city){
		$data_weather = $this->_resources[$resource];
		$get_data = $data_weather->get_data($city);
		return $data_weather->get_json($get_data);
	}

}



$start = new HttpServer();
$start->start();