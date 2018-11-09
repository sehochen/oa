<?php

namespace app\admin\validate;

use think\Validate;

class Doc extends Validate
{   //添加公文是的验证规则
    protected $rule = [
        'title'  =>  'require|max:20',
        'content'  =>  'require',
    ];
    protected $message  =   [
        'title.require' => '标题必须填写',
        'content.require' => '内容必须填写',
    ];

}
