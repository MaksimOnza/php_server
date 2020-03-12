<?php

class Cache
{

	private $cache = [];

	public function add($key, $data, $ttl)
	{
		$this->cache = array(
			$key => array(
				'data' => $data,
				'time'=> $ttl,
				'expire_time' => time() + $ttl
			)
		);
	}

	public function get($key)
	{
		if($this->cache[$key]['expire_time'] < time())
		{
			return $this->cache[$key];
		}
		return null;
	}
}