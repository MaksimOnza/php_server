<?php

require_once('manag_cashe.php');


class Cache
{

	private $ttl1;
	private $manag_cashe;

	function __construct($ttl){
		$this->manag_cashe = new ManagCashe();
		$this->ttl1 = $ttl;
	}

	public function set($key, $data)
	{
		$this->manag_cashe->set_cashe($key, $data, time() + $this->ttl1);
	}

	public function get($key)
	{
		try{
			return $this->manag_cashe->get_cashe($key);
		}
		catch(Exception $e){
			return False;
		}
	}
}

