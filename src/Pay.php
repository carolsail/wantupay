<?php

namespace Carolsail\Wantupay;

use Carolsail\Wantupay\Utils\Str;
use Exception;

class Pay {
    const MODE_PROD = "prod";
    const MODE_SANDBOX = "sandbox";
    const URL = [
        self::MODE_PROD => 'https://merchants-api.wantu.cn/paygate',
        self::MODE_SANDBOX => 'https://sandbox-merchants.wantu.cn/paygate'
    ];

	protected $config;


	public function __construct($config)
	{
        $mode = isset($config['mode']) ? $config['mode'] : self::MODE_PROD;
        $config['url'] = self::URL[$mode];
        $config['send_time'] = date('Y-m-d H:i:s');
        $config['version'] = '1.0';
        $config['time_expire'] = date('Y-m-d H:i:s', strtotime('+1 day'));
        unset($config['mode']);
		$this->config = $config;
	}

	public static function __callStatic($method, $params)
    {
        $app = new self(...$params);
        return $app->create($method);
    }

    protected function create($method)
    {
		$gateway = __NAMESPACE__.'\\Gateways\\'.Str::studly($method);
		if (class_exists($gateway)) {
            return new $gateway($this->config);
        }
        throw new Exception("Gateway [{$method}] Not Exists");
    }
}