<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Dapa extends Conf
{
        /**
         * 显示创建资源表单页.
         *
         * @return \think\Response
         */
        public function create()
        {   $data=input('param.');
            $dapa=new \app\admin\model\Dapa();
            if(request()->Post()){
                /*定义的验证规则*/
                $validate = validate('User');
                if(!$validate->check($data)){
                    $this->error($validate->getError());
                }else{
                    if($dapa->save($data)){
                        $this->success('添加成功','showlist',1);
                    }else{
                        $this->error('添加失败',1);
                    }
                }
            }

            $list=$dapa->getCats();
            $this->assign('list',$list);
            return view();
        }

        /**
         * 保存新建的资源
         *
         * @param  \think\Request  $request
         * @return \think\Response
         */
        public function showlist()
        {   $dapa=new \app\admin\model\Dapa();
            $list=$dapa->getCats();

            $this->assign(array(
                'list'=>$list,
//                'lt'=>$lt,
            ));
            return view();
        }





        public function upd()
        {   $dapa=new \app\admin\model\Dapa();
            $data=input('post.');
            //修改数据
            if(request()->Post()){
                $ids=$dapa->getSubIds($data['id']);
                if(in_array($data['pid'],$ids)){
                    $this->error('分类下面有子分类不可作为上级分类');
                }
                if($dapa->where('id',input('id'))->update($data)){
                    $this->success('修改成功','showlist',1);
                }else{
                    $this->error('修改失败');
                }
            }
            //展示修改界
            $list=$dapa->getCats();
            $lt=$dapa->where('id',input('id'))->find();

            $this->assign(array(
                'list'=>$list,
                'lt'=>$lt,
            ));
            return view();
        }

        /**
         * 删除指定资源
         *
         * @param  int  $id
         * @return \think\Response
         */
        public function delete($id)
        {   $data=input('id');
            $dapa=new \app\admin\model\Dapa();
            $ids=$dapa->getSubIds($data);
            if(count($ids>1)){
                $this->error('分类下面有子分类不可删除');
            }

            if($dapa->where('id',$data)->delete()){
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }





}
