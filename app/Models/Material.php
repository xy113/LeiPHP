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
 * Time: 上午9:39
 */

namespace App\Models;


use Core\Model;

class Material extends Model
{

    protected $table = 'material';
    protected $primaryKey = 'id';
    public $timestamps = true;

}
