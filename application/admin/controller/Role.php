<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Role extends Conf
{

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {   $list=db('role')->select();
    $this->assign('list',$list);
        return view();
    }

    //权限分配显示
    public function fenpei()
    {
        /*查询被分配权限的角色信息*/
        $roleinfo=db('role')->find(input('id'));
       //把字符串转成数组
        $info=explode(',',$roleinfo['role_auth_ids']);
        /*把$info分配到模板给前台使用
        查询被分配权限的角色信息*/

        //获得"被分配权限"的角色信息
        $list=db('role')->where('role_id',input('id'))->find();
        //获取超级管理员对应权限
        $listA=db('auth')->where('auth_level',0)
            ->select();//父级
        $listB=db('auth')->where('auth_level',1)
            ->select();//子级、和父级的查询结果是一样的
        $this->assign('list',$list);

        //结果输出到模板
        $this->assign([
            'listA'=>$listA,
            'listB'=>$listB,
            'info'=>$info
        ]);
        return view();
    }
    //权限分配添加
    public function fenadd()
    {
        $data=input('param.');
        if(request()->Post()){
            //两个逻辑：展示、收集
            $role = new \app\admin\model\Role();
            $res = $role -> roleAuth($data['role_id'],$data['role_auth_ids']);
            if($res){
                $this -> success('分配权限成功');
            }else {
                $this->error('分配权限失败');
            }
        }
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
