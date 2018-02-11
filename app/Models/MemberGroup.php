<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2018/2/9
 * Time: 上午9:15
 */

namespace App\Models;


use Core\Model;

class MemberGroup extends Model
{

    protected $table = 'member_group';
    protected $primaryKey = 'gid';

    /**
     * @return bool|mixed
     */
    public function updateCache(){
        $grouplist = array();
        foreach ($this->select() as $group){
            $group = get_object_vars($group);
            $grouplist[$group['gid']] = $group;
        }
        return cache('member_groups', $grouplist);
    }

    /**
     * @return bool|mixed
     */
    public function getCache(){
        $grouplist = cache('member_groups');
        if (is_array($grouplist)){
            return $grouplist;
        }else {
            $this->updateCache();
            return $this->getCache();
        }
    }
}
