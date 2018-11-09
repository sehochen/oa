<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{   //添加部门时的验证规则
    protected $rule = [
        'name'  =>  'require|max:25',
    ];
    protected $message  =   [
        'name.require' => '部门名称必须填写',
    ];

}
