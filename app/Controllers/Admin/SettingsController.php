<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/9
 * Time: 下午2:09
 */

namespace App\Controllers\Admin;


use App\Models\Settings;

class SettingsController extends BaseController
{
    /**
     * index
     */
    public function index()
    {

    }

    /**
     * 保存配置信息
     */
    public function save(){
        if ($this->checkFormSubmit()){
            $settings = $_GET['settings'];
            foreach ($settings as $skey=>$svalue){
                if(is_array($svalue)) $svalue = serialize($svalue);
                Settings::getInstance()->data(array('skey'=>$skey, 'svalue'=>$svalue))->replaceAdd();
            }
            Settings::getInstance()->updateCache();
            $this->showSuccess('update_succeed');
        }else {
            $this->showError('undefined_action');
        }
    }

    /**
     * @param $name
     * @param $args
     */
    function __call($name, $args){
        global $_G, $_lang;
        $settings = $this->getSettings();

        $this->set('title', '系统配置');
        include view('settings/'.$name);
    }

    /**
     * 获取系统配置内容
     * @return array
     */
    private function getSettings(){
        $settings = array();
        foreach (Settings::getInstance()->select() as $setting){
            $value = unserialize($setting['svalue']);
            $settings[$setting['skey']] = is_array($value) ? $value : $setting['svalue'];
        }
        return $settings;
    }
}
