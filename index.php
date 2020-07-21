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
	private $_parameters = [];

	public function __construct(){
		$this->operator = new Cache(10);
		$this->_resources = array(
			'weatherstack' => new WeatherstackResource(WEATHERSTACK_ACCESS_KEY),
			'openweathermap' => new OpenweathermapResource(OPENWEATHERMAP_ACCESS_KEY),
			'worldweatheronline' => new WorldweatheronlineResource(WORLDWEATHERONLINE_ACCESS_KEY),
		);
	}

	public function start(){
		require_once('form.php');
		$function_json2 = $_GET['function_json2'];
		$city = $_GET['city'];
		$resource = $_GET['resources'];
		$this->_parameters = $_GET['parameters'];
		//echo gettype($this->_parameters).'</br>';
		$data_weather = $this->operator->get($resource.$city);
		if(!$data_weather)
		{
			$data_weather = $this->get_data_weather($resource, $city, $function_json2);
			//echo $data_weather.' -> $data_weather'; print_r($data_weather);
			$this->operator->set($resource.$city, $data_weather);
		}
		echo $this->display_weather($data_weather);
		//$clone = $this->get_data_weather_clone($resource, $city);
		
		//print_r($clone);
	}


	private function display_weather($data_weather)
	{
		$description = $data_weather['desc'];
		//echo '</br>'.$description.'$description</br>';/////////////////////
		if(!($description == ''))
		{
			return json_encode($data_weather);
		}
		return 'wrong city';
	}


	private function get_data_weather($resource, $city, $function_json2){
		$data_weather = $this->_resources[$resource];
		$get_data = $data_weather->get_data($city);
		if($function_json2){
			$out_data = $data_weather->get_json2($get_data, $this->_parameters);
		}else{
			$out_data = $data_weather->get_json($get_data, $this->_parameters);
		}
		return $out_data;
	}



	private function get_data_weather_clone($resource, $city){
		$data_weather = $this->_resources[$resource];
		$data = $data_weather->get_data($city);
		return json_decode($data, true);
	}

}



$start = new HttpServer();
$start->start();