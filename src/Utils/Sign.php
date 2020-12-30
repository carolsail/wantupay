<?php
namespace Carolsail\Wantupay\Utils;

/**
 * 支付宝Sign签名算法类
 */
class Sign
{
    /**
     * 生成MD5签名
     */
    public static function md5($args,$key)
    {
        //签名步骤一：按字典序排序参数
        ksort($args);
        $string = self::toUrlParams($args);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 验证MD5签名
     * @param $args
     * @param $key
     * @return bool
     */
    public static function verifyMd5($args,$key)
    {
        return self::md5($args,$key) == $args['sign'];
    }

    /**
     * 格式化参数格式化成url参数
     */
    private static function toUrlParams($args)
    {
        $buff = "";
        $ignores = ['pay_type','api_type','sign'];
        foreach ($args as $k => $v)
        {
            if(!in_array($k,$ignores) && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}