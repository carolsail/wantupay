<?php

namespace Carolsail\Wantupay\Gateways\Alipay;

class WebGateway extends Gateway{
	protected $url;
	protected $payload;

	public function __construct($url, $payload){
		$this->url = sprintf($url.'/%s', 'web');
		$this->payload = json_encode($payload);
	}
}