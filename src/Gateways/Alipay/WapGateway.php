<?php
namespace Carolsail\Wantupay\Gateways\Alipay;

class WapGateway extends Gateway{
	
	protected $url;
	protected $payload;

	public function __construct($url, $payload){
		$this->url = sprintf($url.'/%s', 'wap');
		$this->payload = json_encode($payload);
	}
}