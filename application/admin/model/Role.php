<?php

namespace app\admin\model;

use think\Model;

class Role extends Model
{
    public function roleAuth($roleid,$authid){
       /*① 制作$authid PHP implode() 函数把数组分割成字符串
        string(55) "101,106,107,102,108,109,103,110,111,104,112,105,116,117"*/
        $authidplus = implode(',',$authid);
        /*②制作控制器和方法的连接符号
        根据选中的id信息，查出对应的权限记录，遍历并从中获取每个权限的controller和action的名称
        */
        $authinfo=db('auth')->select($authidplus);
        $s = "";
        foreach($authinfo as $k =>$v){
            if(!empty($v['auth_c']) && !empty($v['auth_a']))
                $s.= $v['auth_c']."-".$v['auth_a'].",";
        }
        $s = rtrim($s,',');
        $sql="update oa_role set role_auth_ids='$authidplus',role_auth_ac='$s'
          where role_id='$roleid'";
        //执行语句
        return $this->execute($sql);
    }
}
