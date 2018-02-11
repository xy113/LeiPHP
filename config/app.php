<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2018/2/8
 * Time: 上午11:08
 */

return array(
    //mysql配置
    'mysql'=>array(
        'type'          =>  'mysqli',    // 数据库连接方式
        'host'          =>  'localhost', // 服务器地址
        'database'      =>  'db_leiphp',    // 数据库名
        'user'          =>  'db_leiphp',      // 用户名
        'password'      =>  'db_leiphp',    // 密码
        'port'          =>  '3306',      // 端口
        'prefix'        =>  'pre_',    // 数据库表前缀
        'charset'       =>  'utf8',      // 数据库编码默认采用utf8
    ),
    //cookie配置
    'cookie'=>array(
        'expire'    =>  0,       // Cookie有效期
        'domain'    =>  '',      // Cookie有效域名
        'path'      =>  '/',     // Cookie路径
        'prefix'    =>  '',      // Cookie前缀 避免冲突
        'secure'    =>  false,   // Cookie安全传输
        'httponly'  =>  '1',      // Cookie httponly设置
    ),
    //缓存配置
    'cache'=>array(
        'type'     =>  'file',
    ),
    'redis'=>array(

    ),

    /*应用配置*/
    'FOUNDERS'=>array('1000000'), //创始人UID
    'AUTHKEY'=>'000000000000',//信息加密秘钥
    'STATICURL'=>'/static/',  //静态资源修正地址
    'ATTACHDIR'=>ROOT_PATH.'data/', //附件保存目录
    'ATTACHURL'=>'/data/',  //附件修正地址
    'AVATARDIR'=>ROOT_PATH.'data/avatar/', //头像保存目录

    //自动加载文件配置
    'AUTO_LOAD_CONFIG'=>array(),
    'AUTO_LOAD_LANGS'=>array('post'),
    'AUTO_LOAD_FUNCTIONS'=>array(''),
);
