<?php

namespace Carolsail\Wantupay\Gateways;

use Carolsail\Wantupay\Utils\Str;
use Carolsail\Wantupay\Utils\Sign;
use Exception;

class Alipay {
    protected $config;
    protected $url;
    protected $secret;

	public function __construct($config){
        $this->url = $config['url'];
        $this->secret = $config['md5Key'];
        $config['pay_channel'] = 2;
        $config['fee_type'] = isset($config['fee_type']) ? $config['fee_type'] : 'HKD'; // CN, HKD
        $config['payment_inst'] = isset($config['payment_inst']) ? $config['payment_inst'] : 'ALIPAYHK'; // ALIPAYCN, ALIPAYHK
        unset($config['url']);
        unset($config['md5Key']);
        $this->config = $config;
	}

	public function __call($method, $params)
    {
        return $this->pay($method, ...$params);
    }

    public function pay($method, $params = [])
    {
        $gateway = get_class($this).'\\'.Str::studly($method).'Gateway';
        if (class_exists($gateway)) {
            $payload = array_merge($this->config, $params);
            $payload['sign'] = (new Sign)->md5($payload, $this->secret);
            $app = new $gateway($this->url, $payload);
            return $app->pay();
        }
        throw new Exception("Pay Gateway [{$method}] not exists");
    }
}