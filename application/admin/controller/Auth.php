<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Auth extends Conf
{
    public function index()
    {   //查出所有数据并按照auth_path排序
        $list=db('auth')->order('auth_path')->paginate(16);

        $this->assign('list',$list);
        return view();
    }
    public function add()
    {
        if(request()->Post()){
            $data=input('param.');
            $auth=new \app\admin\model\Auth();
            //调用模型函数
            $res=$auth->addAuth($data);
            if($res){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }
        //查出所有数据并按照auth_path排序
        $list=db('auth')->where('auth_level',0)->select();
        $this->assign('list',$list);
        return view();
    }

}
