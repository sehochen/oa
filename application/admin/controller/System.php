<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class System extends Conf
{

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {    $user = new \app\admin\model\System();
        if(request()->Post()){
            $data=input('param.');

            $res=$user-> where('id',$data['id'] )->save($data);

            if($res){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }
        //查询数据输出到模板
        $da = db('System')->where('id',1)-> find();

        $this->assign('list',$da);
        return view();
    }

    //请假单打印
    public function add()
    {

        return view();
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
