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
		readfile('form.html');
		$city = $_GET['city'];
		$resource = $_GET['resources'];
		if($this->operator->check_cache($resource.$city)){
			$data_weather = $this->operator->kesh_dict;
		}else{
			$data_weather = $this->get_data_weather($resource, $city);
		}
		$this->operator->kesh_dict = array(
			$city.$resource => array(	
					'temp'=> $data_weather['temp'],
					'desc'=> $data_weather['desc'],
					),
			'time'=> time()
			);
		$this->display_weather($this->operator->kesh_dict, $city.$resource);
	}


	function display_weather($array, $resource){
		$description = $this->operator->kesh_dict[$resource]['desc'];
		while($description){
			echo json_encode($this->operator->kesh_dict[$resource]);
			return json_encode($this->operator->kesh_dict[$resource]);
		}
		while(!$description){
			echo 'Maybye wrong the city?';
			break;
		}
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