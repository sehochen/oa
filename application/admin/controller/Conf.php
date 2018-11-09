<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Conf extends Controller
{
    //构造函数自动执行,防止用户不登录就可以操作后台数据
    public function _initialize()
    {
        if(session('name')==NULL){
            $this->error('请登录后再来操作','admin/login/index');
        }
        //防止用户翻墙操作
        //①获取当前用户访问的“控制器/方法”的权限信息
        $nowac=request()->controller()."-".request()->action();

        /*②获取当前用户“允许”访问的信息
        admin_id---role---auth
        获得登录系统管理员的信息，进而获得角色id*/

        $admin_id=session('id');
        $admin_name=session('name');
        $user_info=db('staff')->find($admin_id);
        $role_id= $user_info['role_id'];

        //③根据$role_id获得角色信息
        $role_info=db('role')->find($role_id);
        //④获得角色对应控制器-操作方法信息
        $auth_ac=$role_info['role_auth_ac'];
        //（扩展）默认允许大家都可以访问的权限
        $allow_ac="Index-index,Index-home,Email-send,Email-falist,Email-shoulist,
        Email-xia,Email-getContent";
        //⑤当前访问的权限与“允许”访问权限对比
        /*strpos()判断一个小的字符串在一个大的字符串首次出现的位置
        如果没有出现就是false*/
        if(strpos($auth_ac,$nowac)===false && strpos($allow_ac,$nowac)===false&& $admin_name!='admin'){
            $this->error('没有权限访问','index/home');
        }
    }



    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
