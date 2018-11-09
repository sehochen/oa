<?php

namespace app\admin\model;

use think\Model;

class Auth extends Model
{

    public function addAuth($data){
        //①根据data（只有4个字段）先添加一条数据
        $newid=$this->save($data);
        // 获取自增ID
        $auth_id=$this->auth_id;
        //②制作auth_path
        if($data['auth_pid']==0){
            //1.)顶级权限auth_path===新纪录主键的id
            $path=$auth_id;
        }else{
            //2.)非顶级权限根据pid获得父级权限信息，进而获取全路径
            //父级全路径-新纪录主键的id
            $pinfo=$this->find($data['auth_pid']);
            $path=$pinfo['auth_path'].'-'.$auth_id;
        }
        //③制作auth_level
        //全路径’-‘数量就是auth_level的值
        //substr_count()计算一个字符串出现了几次
        $level=substr_count($path,'-');
        //④更新数据库
        $auth = Auth::get($auth_id);
        $auth->auth_path     = $path;
        $auth->auth_level    = $level;
        return $auth->save();
    }
}
