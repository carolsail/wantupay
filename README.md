**注意： 基于wantupay二次封装，需对wantupay开发文档有过了解**
- 查看[wantupay文档](https://github.com/carolsail/wantupay)

## 开发测试环境
- PHP 5.6+
- composer

## 支持的支付方法
### 1、支付宝

|  method   |   描述       |
| :-------: | :-------:   |
|  web      | 电脑支付     |
|  wap      | 手机网站支付 |

### 2、微信
- 待跟进...

## 安装
```shell
composer require carolsail/wantupay v1.0.0
```

## 使用说明

### 支付宝
```php
<?php

namespace App\Http\Controllers;

use Carolsail\Wantupay\Pay;

class PayController
{
    public function index()
    {
        $config = [
            'merchant_account' => '***', // 申请获取
            'store_account' => '***', // 申请获取
            'md5Key' => '***', // 申请获取
            'mode' => 'prod', // 模式： prod || sandbox
            'notify_url' => ".../notify", // 异步回调
            'return_url' => ".../return", // 同步回调
            'fee_type' => 'HKD', // HKD为默认值
            'payment_inst' => 'ALIPAYHK' // ALIPAYHK为默认值
        ];
        $order = [
            'out_trade_no' => 'test123', // 生成唯一订单号
            'total_fee' => 1 * 100, // 总价为分 * 100
            'subject' => 'test',
        ];

        // $url = Pay::alipay($config)->web($order);
        $url = Pay::alipay($config)->wap($order);
        return redirect($url); // 重定向
    }

    public function return()
    {
        $data = input('param.');
        if(isset($data['out_trade_no']) && isset($data['trade_status']))
        {
            if($data['trade_status'] == 'TRADE_FINISHED' || $data['trade_status'] == 'TRADE_SUCCESS') {
                // 成功响应
            }
        }
        // 失败响应
    }

    public function notify()
    {
        $raw_post_data = file_get_contents('php://input');
        $raw_post_data =json_decode($raw_post_data, true);
        if($raw_post_data && isset($raw_post_data['return_code']) && isset($raw_post_data['trade_status']) && !empty($raw_post_data['out_trade_no']) ){
            if($raw_post_data['return_code'] == 200 && $raw_post_data['trade_status'] == 'SUCCESS' ){
                // 处理诸如订单状态等逻辑...
            }
        }
    }
}
```
