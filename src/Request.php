<?php

namespace Kelkoo;

class Request
{	
	const URL = "http://[country].shoppingapis.kelkoo.com";

	private $_key;
	
	private $_trackingId;

	private $_url;

	protected $_result = null;

	public function __construct( $key, $trackingId, $country )
	{
		$this->key = $key;
		$this->trackingId = $trackingId;
		$this->url = str_replace('[country]',$country,self::URL);
	}

	public function getResult()
	{
		if( !empty($this->result) ) {
			return $this->result;
		} return "empty";
	}

	protected function request( $path = "", $type = "xml" )
	{
		$url = $this->signUrl($path);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		if($type=="json") curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$result = curl_exec($ch); 
		curl_close($ch);

		if($type === 'json') {
			$this->result = json_decode($result);
		} else $this->result = simplexml_load_string($result);
	}

	protected function signUrl( $path = "" )
	{
		$timestamp = time();
		$path      = str_replace(" ","+",$path);
		$tmp       = $path . "&aid=" . $this->trackingId . "&timestamp=" . $timestamp;
		$string    = $path . "&aid=" . $this->trackingId . "&timestamp=" . $timestamp . $this->key;
		$token     = str_replace(array("+", "/", "="), array(".", "_", "-"), base64_encode(pack('H*',md5($string))));
		$sign      = $this->url . $tmp . "&hash=" . $token; 

		return $sign;
	}
}