<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;

class Doc extends Conf
{




    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {   $list=db('doc')->paginate(10);
        $this->assign('list',$list);
        return view();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {   $data=input('post.');
        $data['addtime']=time();

        if(request()->Post()){
            //①验证规则，使用助手函数实例化验证器
            $validate = validate('Doc');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            //①验证规则end
            $user = new \app\admin\model\Doc();
            if($user->save($data)){
                $this->success('添加公文成功','index');
            }else{
                $this->error('添加公文失败');
            }
        }
        return view();
    }
    //附件下载
    public function xiazai()
    {
        //接收id
        $id = input('id');
        //查询数据
        $data = db('Doc')->where('id',$id)-> find();
        //下载代码,ROOT_PATH 框架应用根目录
        $file =ROOT_PATH.$data['filepath'];
        //输出文件
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        //输出缓冲区
        readfile($file);
    }

    //showContent方法
    public function showContent(){
        //接收id
        $id = input('id');
        //查询数据
        $data = db('Doc')->where('id',$id)-> find();
        //输出内容，并且还原被转移的字符
        echo htmlspecialchars_decode($data['content']);
    }
    //公文修改
    public function upd()
    {
        $user = new \app\admin\model\Doc();
        if(request()->Post()){
            $res=$user->save(input('post.'),['id' => input('id')]);
            if($res){
                $this->success('修改公文成功','index');
            }else{
                $this->error('修改公文失败');
            }
        }
        //查询数据输出到模板
        $data = db('Doc')->where('id',input('id'))-> find();
        $this->assign('list',$data);
        return view();
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {   $doc = new \app\admin\model\Doc();
        $user = $doc::get(input('id'));

        if($user->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}
