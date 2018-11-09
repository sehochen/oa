<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
class Email extends Conf
{

    /**
     *
     *
     * 发件箱
     */
    public function send()
    {   if(request()->post()){
        $data=input('param.');
        $data['addtime']=time();
        $data['formid']=session('id');
        $res=new \app\admin\model\Email();
        if($res->save($data)){
            $this->success('发送成功');
        }else{
            $this->error('发送失败');
        }
        }
        $data=db('staff')->select();
        $this->assign('list',$data);
        return view();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function falist()
    {
        /*[ SQL ] SELECT `a`.*,`b`.`truename` FROM `oa_email` `a`
        INNER JOIN `oa_staff` `b` ON `a`.`toid`=`b`.`id` LIMIT 0,10 */

        $list=db('email')->field('a.*,b.truename')->alias('a')
            ->join('staff b','a.toid=b.id' )
            ->where("a.formid" ,session('id'))
            ->paginate(10);
        $this->assign('list',$list);

        return view();
    }


    //附件得下载
    public function xia()
    {
        //接收id
        $id = input('id');
        //查询数据
        $data = db('Email')->where('id',$id)-> find();
        //下载代码,ROOT_PATH 框架应用根目录
        $file =ROOT_PATH.$data['filepath'];
        //输出文件
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        //输出缓冲区
        readfile($file);
    }

    public function shoulist()
    {
        $list=db('email')->field('a.*,b.truename')->alias('a')
            ->join('staff b','a.formid=b.id' )
            ->where("a.toid",session('id'))
            ->paginate(10);

        $this->assign('list',$list);

        return view();
    }


    //getContent
    public function getContent(){
        //获取id
        $id = input('id');
        //查询数据
        $data = db('email') -> where("id",$id ) -> find();
        //如果data为真则修改邮件的状态
        if($data['isread'] == '0'){
            //修改状态, 更新数据表中的数据
            db('email')->where('id',$id)->update(['isread' => 1]);
        }
        //输出内容
        echo $data['content'];
    }



    //getCount
    public function getCount(){
        if(request()->isAjax()){

            //查询当前用户未读邮件的数量
            $res = db('email') -> where('isread',0) -> count();
            //输出数字where("a.toid",session('id'))
            return $res;
        }
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
