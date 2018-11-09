<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
class Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return view();
    }


    public function login()
    {
       if(request()->Post()){
           //①接受数据
           $data=input('param.');
           //②查询数据是否存在
           $res=db('staff')->where('name',$data['name'])->find();
           /*③定义的验证规则*/
           $validate = validate('Log');
           if(!$validate->check($data)){
               $this->error($validate->getError());
           }/*④定义的验证码规则*/
           if(!captcha_check($data['code'])){
               $this->error('验证码错误');
           }
           //⑤判断条件
           if($res != false ){
               if($data['password']==$res['password']){
                   //⑥ 赋值（当前作用域）
                   Session("id",$res['id']);
                   Session("name",$res['name']);
                   $this->success('','admin/index/index',0);
               }else{
                   $this->error('用户名或密码错误','admin/login/index',1);
               }
           }
       }
    }
    //验证码验证器
    public function codesrc() {
        $captcha = new \think\captcha\Captcha();
        // 设置验证码字符为纯数字
        $captcha->codeSet = '0123456789';
        $captcha->useNoise= FALSE;
        $captcha->useCurve= FALSE;
        $captcha->imageH= 50;
        $captcha->imageW= 120;
        $captcha->fontSize= 16;
        $captcha->length= 4;
        return $captcha->entry();
    }


    //退出方法
    public function logout(){
        //清除session
        session('name', null);
        //跳转到登录页面
        $this->success('退出成功','admin/login/index');
    }
}
