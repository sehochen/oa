<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Staff extends Conf
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        /* [ SQL ] SELECT `a`.*,`b`.`name` FROM `oa_staff` `a`
         INNER JOIN `oa_dapa` `b` ON `a`.`pid`=`b`.`id` */
        //连表查询因为所属部门需要连表
        $list=Db('staff')->field('a.*,b.name')->alias('a')
            ->join('dapa b','a.pid=b.id' )->paginate(10);
//        dump($list);
        $this->assign('list',$list);
        return view();
    }
    public function add()
    {   $data=input('param.');
        $data['time']=time();
        $res=new \app\admin\model\Staff();
            if(request()->Post()){
                // 调用Staff验证器类进行数据验证
                $result = $res->validate('Staff')->save($data);
                if(false === $result){
                    // 验证失败 输出错误信息
                    $this->error($res->getError());
                }
                // 调用Staff验证器类进行数据验证
                if($result){
                    $this->success('添加成功');
                }else{
                    $this->error('添加失败');
                }
            }
        //职务查询
        $info=db('role')->select();
        $this->assign('info',$info);
        //职务查询
        //查询出所有部门
        $dapa=new \app\admin\model\Dapa();
        //调用之前的排序规则
        $list=$dapa->getCats();
        $this->assign('list',$list);
        return view();
    }
    public function upd()
    {   $data=input('id');
        if(request()->Post()){
            $res=db('staff')->where('id',$data)->update(input('param.'));
            if($res){
                $this->success('修改成功','index');
            }else{
                $this->error('修改失败');
            }
        }
        $lt=db('staff')->where('id',$data)->find();
        //查询出所有部门
        $dapa=new \app\admin\model\Dapa();
        //调用之前的排序规则
        $list=$dapa->getCats();
        $this->assign([
            'list'=>$list,
            'lt'=>$lt
        ]);
        return view();
    }

    public function delete($id)
    {
        if(db('staff')->where('id',input('id'))->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }



}
