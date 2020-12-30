<?php

namespace Carolsail\Wantupay\Gateways\Alipay;

use Carolsail\Wantupay\Utils\Http;
use Exception;

abstract class Gateway{
	public function pay(){
    	$res = (new Http)->post($this->url, $this->payload);
    	$res = json_decode($res, true);
    	if(isset($res['return_code']) && $res['return_code'] == 200 && $res['url'] ){
	       return $res['url'];
	    }
	    if(isset($res['return_code']) && isset($res['return_msg'])){
	    	throw new Exception($res['return_code'].': '.$res['return_msg']);
	    }
	    throw new Exception('System Error');
	}
}