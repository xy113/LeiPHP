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
 * Time: 下午3:35
 */

namespace App\Controllers\Admin;


use App\Models\MemberGroup;

class MembergroupController extends BaseController
{
    /**
     * 会员分组管理
     */
    public function index(){
        global $_G,$_lang;

        if ($this->checkFormSubmit()){
            $delete = $_GET['delete'];
            if ($delete) {
                foreach ($delete as $gid){
                    MemberGroup::getInstance()->where(array('gid'=>$gid))->delete();
                }
            }

            $grouplist = $_GET['grouplist'];
            if ($grouplist) {
                foreach ($grouplist as $gid=>$group){
                    if ($group['title']) {
                        if ($gid > 0){
                            MemberGroup::getInstance()->where(array('gid'=>$gid))->data($group)->save();
                        }else {
                            MemberGroup::getInstance()->data($group)->add();
                        }
                    }
                }
            }
            MemberGroup::getInstance()->updateCache();
            $this->showSuccess('update_succeed');
        }else {

            $grouplist = array();
            foreach (MemberGroup::getInstance()->select() as $group){
                $grouplist[$group->type][$group->gid] = get_object_vars($group);
            }
            include view('member/group');
        }
    }
}
