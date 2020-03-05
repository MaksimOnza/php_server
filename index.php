<?php

require_once('config.php');
require_once('resources/openweathermap.php');
require_once('resources/weatherstack.php');
require_once('resources/worldweatheronline.php');


///////////////////////////////////////////////////////////////
//define("CITY", "city");
//define("RESOURCE", "resource");
//define("OPENWEATHERMAP_ACCESS_KEY", "55fc030a936d5e205ca578d8a03011ba");
//define("WORLDWEATHERONLINE_ACCESS_KEY","d48ab845d78e492081b192620202001");
//define("WEATHERSTACK_ACCESS_KEY", "719d3fe6203f73509524e0bca348cb53");
$_resources = array(
	'weatherstack' => new WeatherstackResource(WEATHERSTACK_ACCESS_KEY),
	'openweathermap' => new OpenweathermapResource('55fc030a936d5e205ca578d8a03011ba'),
	'worldweatheronline' => new WorldweatheronlineResource(WORLDWEATHERONLINE_ACCESS_KEY),
);



class HttpProcessor{
		
	//private const WEATHERSTACK_ACCESS_KEY = '719d3fe6203f73509524e0bca348cb53';
	//private const OPENWEATHERMAP_ACCESS_KEY = '55fc030a936d5e205ca578d8a03011ba';
	//private const WORLDWEATHERONLINE_ACCESS_KEY = 'd48ab845d78e492081b192620202001';

	//private $weather1 = new WeatherstackResource('719d3fe6203f73509524e0bca348cb53');
	//private $weather2 = new OpenweathermapResource('55fc030a936d5e205ca578d8a03011ba');
	//private $weather3 = new WorldweatheronlineResource('d48ab845d78e492081b192620202001');


	//private $resources = array(
	//	'weatherstack'=> new WeatherstackResource('719d3fe6203f73509524e0bca348cb53'),
	///	'openweathermap'=> 2,//new OpenweathermapResource('55fc030a936d5e205ca578d8a03011ba'),
	//	'worldweatheronline'=> 3//new WorldweatheronlineResource('d48ab845d78e492081b192620202001'),
	//);

	function do_GET(){
		$kesh_dict = array();
		$temperature = '';
		//$data_weather = NULL;
		$city = $_GET['city'];
		$resource = $_GET['resource'];
		$current_time = time();
		if (array_key_exists($city.$resource, $kesh_dict)){
			if (($current_time - $kesh_dict['time']) > 3600){
				$data_weather = $this->get_data_weather($resource, $city);
				$description = $data_weather['desc'];
				$temperature = $data_weather['temp'];
			}else{				
				$temperature =  $kesh_dict[$city]['temp'];
				$description = $kesh_dict[$city]['desc'];
			}
		}else{
			echo 'Выброшено исключение';
			$data_weather = $this->get_data_weather($resource, $city);
			$description = $data_weather['desc'];
			$temperature = $data_weather['temp'];
		}
		$_kesh_dict = array(
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
		$data_weather = new OpenweathermapResource(OPENWEATHERMAP_ACCESS_KEY);//$_resources[$resource];
		$get_data = $data_weather->get_data($city);
		return $data_weather->get_json($get_data);
	}

}



$start = new HttpProcessor();
$start->do_GET();
 ?>