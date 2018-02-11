<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/7/24
 * Time: 下午5:35
 */
namespace Core;
class Validate{
    /**
     * 正则验证邮箱地址
     * @param string $email
     * @return boolean
     */
    public static function isemail($email) {
        return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
    }

    /**
     * 正则验证手机号码
     * @param string $mobile
     * @return number
     */
    public static function ismobile($mobile){
        return preg_match('/^1[3|4|5|6|7|8][0-9]\d{4,8}$/', $mobile);
    }
}
