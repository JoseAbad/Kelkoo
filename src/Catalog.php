<?php

namespace Kelkoo;

class Catalog extends Request
{
	const PATH = "/V3/catalogSearch";

	private $_keys = ['category','start','results','sort','refinement']; 

	private $_mandatory_keys = ['category'];
	
	public function search( $parameters, $type = "xml")
	{	
		if( $this->_checkMandatoryKeys($parameters) === false ) $this->_result = null;

		else {

			foreach ($this->_keys as $key ) {
				$query[$key] = isset($parameters[$key]) ? $parameters[$key] : '';
			}

			$query = http_build_query($query);	
			$path  = self::PATH . '?' . $query;

			$this->request($path,$type);
		}
	}

	private function _checkMandatoryKeys( $parameters )
	{
		foreach ($this->_mandatory_keys as $key) {
			if(!array_key_exists($key, $parameters)) return false;
		} return true;
	}
}