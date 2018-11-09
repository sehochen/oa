<?php

namespace app\admin\model;

use think\Model;

class System extends Model
{
    protected static function init()
    {
        //公文修改之前执行附件上传
        System::event('before_update', function ($data) {
            // 获取表单上传文件file('对应表单的字段名')
            $file = request()->file('pic');
            dump($data);die;
            // 移动到框架应用根目录/public/uploads/ 目录下
            if(request()->file()){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                //查询图片数据
                    $user = Doc::get($data['id']);
                //①删除图片相对index.php文件，static和index在同个目录
                $img='../'.$user->filepath;
                //②拼接删除地址和图片地址
              //$img=$_SERVER['DOCUMENT_ROOT']. '\oa\\'.$user->filepath;
                //判断图片是否存在
                if(file_exists($img)) {
                    //删除图片
                    unlink($img);
                    if($info){
                        // 成功上传后 输出 public\uploads\20181101\xxx.jpg
                        $res= 'public' . DS . 'uploads\\'.$info->getSaveName();
                        //把路径赋值给data,注意data键名对应数据库
                        $data['pic']=$res;
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }

            }
        });



        //公文删除之前执行附件删除
        Doc::event('before_delete', function ($data) {
                //查询图片数据
                $user = Doc::get($data['id']);
                //①删除图片相对index.php文件，static和index在同个目录
                $img='../'.$user->filepath;
                //②拼接删除地址和图片地址
                //$img=$_SERVER['DOCUMENT_ROOT']. '\oa\\'.$user->filepath;
                //判断图片是否存在
                if(file_exists($img)) {
                    //删除图片
                    unlink($img);
                }
            }
        );

    }

}
