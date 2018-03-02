<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2018/2/8
 * Time: 下午5:33
 */

namespace App\Models;


use Core\Model;

class Member extends Model
{

    protected $table = 'member';
    protected $primaryKey = 'uid';

    /**
     * @param $uid
     */
    public static function deleteAll($uid){
        $condition = array('uid'=>$uid);
        Member::getInstance()->where($condition)->delete();
        MemberInfo::getInstance()->where($condition)->delete();
        MemberField::getInstance()->where($condition)->delete();
        MemberLog::getInstance()->where($condition)->delete();
        MemberStat::getInstance()->where($condition)->delete();
        MemberStatus::getInstance()->where($condition)->delete();
        MemberConnect::getInstance()->where($condition)->delete();
        MemberToken::getInstance()->where($condition)->delete();
    }
}
