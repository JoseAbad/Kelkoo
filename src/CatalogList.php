<?php

namespace Kelkoo;

class CatalogList extends Request
{
	const PATH = "/V3/catalogListings";

	private $_keys = ['catalogId','start','results','sort','mobileFriendly']; 

	private $_mandatory_keys = ['catalogId'];
	
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