<?php

namespace app\admin\validate;

use think\Validate;

class Staff extends Validate
{   //添加员工时的验证规则
    protected $rule = [
        // 表示验证name字段的值是否在staff表（不包含前缀）中唯一
        'name'=>'require|unique:staff|max:25',
        'truename'  =>  'require|chs|max:25',
        'password'  =>  'require|max:32',
        'nickname'=>'require|max:25',
    ];
    protected $message  =   [
        'name.require' => '用户名必须填写',
        'name.unique' => '用户名已经存在',
        'name.max' => '用户名超出长度',
        'truename.require' => '姓名必须填写',
        'truename.max' => '姓名超出长度',
        'truename.chs' => '姓名必须汉字',
        'pssword.require' => '密码必须填写',
        'pssword.alphaNum' => '密码必须字母和数字',
        'nickname.require' => '昵称必须填写',
    ];

}
