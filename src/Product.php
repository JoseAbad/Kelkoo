<?php

namespace Kelkoo;

class Product extends Request
{
	const PATH = "/V3/productSearch";

	private $_keys = ['query','category','merchantId','classification','max_refines','refinement','refinement','sort','start','results','show_products','show_subcategories','logicalType','ean','brandName','offerId','productId','automaticOr','mobileFriendly','show_priceBounds','boostMobileResults','imagesOverSsl','rebatePercentage']; 

	private $_mandatory_keys = ['query'];
	
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

	public function getRefinements()
	{
		if( !empty($this->_result) && !empty($this->_result->refinements)) {
			return $this->_result->refinements;
		} return null;
	}

	public function getProducts()
	{
		if( !empty($this->_result) && !empty($this->_result->products)) {
			return $this->_result->products;
		} return null;
	}

	public function getCategories()
	{
		if( !empty($this->_result) && !empty($this->_result->categories)) {
			return $this->_result->categories;
		} return null;
	}

	private function _checkMandatoryKeys( $parameters )
	{
		foreach ($this->_mandatory_keys as $key) {
			if(!array_key_exists($key, $parameters)) return false;
		} return true;
	}
}