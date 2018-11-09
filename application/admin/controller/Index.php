<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Index extends Conf
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $id=session('id');
        $admin_=session('name');
        //①根据session的id获取管理员的信息
        $staff=db('staff')->find($id);
        $role_id=$staff['role_id'];
        //②根据$role_id获取本身的信息
        $role=db('role')->find($role_id);
        $auth_ids=$role['role_auth_ids'];

        //④解决超级管理员权限.id默认为0
        if($admin='admin'){
            //获取超级管理员对应权限
            $listA=db('auth')->where('auth_level',0)
                ->select();//父级
            $listB=db('auth')->where('auth_level',1)
                ->select();//子级、和父级的查询结果是一样的
        }else{
            //③根据$auth_ids获取对应权限
            $listA=db('auth')->where('auth_level',0)->where('auth_id','in',$auth_ids)
                ->select();//父级
            $listB=db('auth')->where("auth_level=1 and auth_id in($auth_ids)")
                ->select();//子级、和父级的查询结果是一样的
        }
        /**连表查询通过sessionID查为了页面能在模板页面显示职位**/
        $data=db('staff')->alias('a')->field('a.*,b.role_name')->
            where('id',$id)->join('role b','a.role_id = b.role_id')->find();
        //dump($data);
        //结果输出到模板
        $this->assign([
            'listA'=>$listA,
            'listB'=>$listB,
            'data'=>$data
        ]);
        return view();
    }


    public function home()
    {
        return view();
    }


}
