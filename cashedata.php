<?php

class CacheData{

	function __construct(){
		$this->kesh_dict = array();
	}

	function delta_time(){
		if((time() - $this->kesh_dict['time']) < 3600){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function check_cache($resource_city){
		if(array_key_exists($resource_city, $this->kesh_dict)){
			if($this->delta_time()){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
}

?>