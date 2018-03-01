<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2018/2/8
 * Time: 下午2:10
 */

namespace App\Controllers\Home;


use App\Models\Member;
use App\Models\Settings;
use Core\Controller;

class IndexController extends Controller
{
    /**
     *
     */
    public function index(){
        include view('index');
    }
}
