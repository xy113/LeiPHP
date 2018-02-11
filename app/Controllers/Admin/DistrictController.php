<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/11
 * Time: 上午10:23
 */

namespace App\Controllers\Admin;


use App\Models\District;
use Core\Pinyin;

class DistrictController extends BaseController
{
    /**
     * 区域信息管理
     */
    public function index(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete) {
                foreach ($delete as $id){
                    District::getInstance()->where(array('id'=>$id))->delete();
                }
            }

            $districtlist = $_GET['districtlist'];
            if ($districtlist) {
                $pinyin = new Pinyin();
                foreach ($districtlist as $id=>$district){
                    if ($district['name']){
                        if (!$district['letter']){
                            $district['letter'] = $pinyin->getFirstChar($district['name']);
                        }

                        if (!$district['pinyin']){
                            $district['pinyin'] = $pinyin->getPinyin($district['name']);
                        }
                        if ($id > 0){
                            District::getInstance()->where(array('id'=>$id))->data($district)->save();
                        }else {
                            $province = intval($_GET['province']);
                            $city     = intval($_GET['city']);
                            $county   = intval($_GET['county']);
                            if ($county){
                                $district['fid'] = $county;
                                $district['level'] = 4;
                            }elseif ($city) {
                                $district['fid'] = $city;
                                $district['level'] = 3;
                            }elseif ($province){
                                $district['fid'] = $province;
                                $district['level'] = 2;
                            }else {
                                $district['fid'] = 0;
                                $district['level'] = 1;
                            }
                            District::getInstance()->data($district)->add();
                        }
                    }
                }
            }
            $this->showSuccess('save_succeed');
        }else {
            $province = intval($_GET['province']);
            $city     = intval($_GET['city']);
            $county   = intval($_GET['county']);

            $provincelist = $citylist = $countylist = $districtlist = array();

            $provincelist = District::getInstance()->where(array('fid'=>0))->order('displayorder ASC,id ASC')->select();
            $districtlist = $provincelist;

            if ($province) {
                $citylist = District::getInstance()->where(array('fid'=>$province))->order('displayorder ASC,id ASC')->select();
                $districtlist = $citylist;
            }

            if ($city) {
                $countylist = District::getInstance()->where(array('fid'=>$city))->order('displayorder ASC,id ASC')->select();
                $districtlist = $countylist;
            }


            if ($county) {
                $districtlist = District::getInstance()->where(array('fid'=>$county))->order('displayorder ASC,id ASC')->select();
            }

            include view('common/district');
        }
    }

}
