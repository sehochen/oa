<?php

namespace app\admin\validate;

use think\Validate;

class Log extends Validate
{   //添加部门时的验证规则
    protected $rule = [
        'name'  =>  'require|max:20',
        'password'  =>  'require|max:20',
    ];
    protected $message  =   [
        'name.require' => '名称必须填写',
        'password.require' => '密码必须填写',
    ];

}
