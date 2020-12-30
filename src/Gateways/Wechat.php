<?php

namespace Carolsail\Wantupay\Gateways;

use Carolsail\Wantupay\Utils\Str;
use Exception;

class Wechat {
	public function __construct($config){
        $config['pay_channel'] = 1;
	}

	public function __call($method, $params)
    {
        return $this->pay($method, ...$params);
    }

    public function pay($method, $params = [])
    {
        $gateway = get_class($this).'\\'.Str::studly($method).'Gateway';
        if (class_exists($gateway)) {
            // $app = new $gateway($this->url, $this->payload);
            // return $app->pay();
            return null;
        }
        throw new Exception("Pay Gateway [{$method}] not exists");
    }
}