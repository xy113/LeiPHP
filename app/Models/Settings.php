<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2018/2/8
 * Time: 下午2:27
 */

namespace App\Models;


use Core\Model;

class Settings extends Model
{

    protected $table = 'settings';
    protected $primaryKey = '';


    /**
     * @return bool|mixed
     */
    public function updateCache(){
        $settings = array();
        foreach ($this->select() as $set){
            $settings[$set['skey']] = $set['svalue'];
        }
        return cache('settings', $settings);
    }

    /**
     * @return bool|mixed
     */
    public function getCache(){
        $settings = cache('settings');
        if (!is_array($settings)){
            $this->updateCache();
            return $this->getCache();
        }else {
            return $settings;
        }
    }
}
