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
	public $duble_weather_data = '';

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
		$_parameters = $_GET['parameters'];
		$data_weather = $this->operator->get($resource.$city);
		if(!$data_weather)
		{
			$data_weather = $this->get_data_weather($resource, $city, $function_json2, $_parameters);
			$this->operator->set($resource.$city, $data_weather);
		}
		$weather_data = $this->display_weather($data_weather);
		$this->out_of_js($weather_data);	
	}


	private function display_weather($data_weather)
	{
		$description = $data_weather['desc'];
		if(!($description == ''))
		{
			return json_encode($data_weather);
		}
		return json_encode($data_weather);//'wrong city';
	}


	private function get_data_weather($resource, $city, $function_json2, $_parameters){
		$data_weather = $this->_resources[$resource];
		$get_data = $data_weather->get_data($city);
		if($function_json2){
			$out_data = $data_weather->get_json2($get_data, $_parameters);
		}else{
			$out_data = $data_weather->get_json($get_data, $_parameters);
		}
		return $out_data;
	}


	public function out_of_js($weather_data){
		echo ' <script type="text/javascript">alert(\''.$weather_data.'\');</script>';
	}

}



$start = new HttpServer();
$start->start();