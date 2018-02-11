<?php
/**
 * ============================================================================
 * 版权所有 (C) 2017 贵州大师兄信息技术有限公司 All Rights Reserved.
 * 网站地址: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2017-05-01
 * $ID: class.Cache.php
 */
namespace Core;
class Cache{
	public static function getInstance(){
		static $instance;
		if(!is_object($instance)) $instance = new Cache();
		return $instance;
	}

    /**
     * 写入缓存
     * @param string $name
     * @param string $value
     * @return bool
     */
    public function set($name, $value='') {
        if(!is_dir(CACHE_PATH)) {
            @mkdir(CACHE_PATH,0777,true);
        }

        $cachedata = serialize($value);
        if (function_exists('gzcompress')){
            $cachedata = gzcompress($cachedata, 5);
        }
        $cachedata = "<?php\n//created:".time()."\n//md5:".md5($cachedata)."\n".$cachedata;
        $result = file_put_contents(CACHE_PATH.$name.'.php', $cachedata);
        if ($result) {
            return true;
        }else {
            die('Can not write to cache files, please check directory ./data/cache/ .');
        }
    }

    /**
     * 获取缓存
     * @param string $name
     * @return bool|mixed
     */
    public function get($name){
        $cachefile = CACHE_PATH.$name.'.php';
        if (is_file($cachefile)){
            $cachedata = file_get_contents($cachefile);
            if ($cachedata !== false){
                $check = substr($cachedata, 33, 32);
                $cachedata = substr($cachedata, 66);
                if ($check != md5($cachedata)){
                    return false;
                }
                if (function_exists('gzcompress')){
                    $cachedata = gzuncompress($cachedata);
                }

                return unserialize($cachedata);
            }
        }else {
            return false;
        }
    }

    /**
     * 删除缓存
     * @param string $name
     * @return bool
     */
    public function rm($name){
        return @unlink(CACHE_PATH.$name.'.php');
    }
}