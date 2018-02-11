<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2018/2/9
 * Time: 上午9:18
 */

namespace App\Models;


use Core\Model;

class MemberSession extends Model
{

    protected $table = 'member_session';
    protected $primaryKey = 'uid';


}
