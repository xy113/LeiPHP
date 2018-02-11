<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2018/2/9
 * Time: 上午9:25
 */

namespace App\Models;


use Core\Model;

class MemberToken extends Model
{

    protected $table = 'member_token';
    protected $primaryKey = 'uid';


}
