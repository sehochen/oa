<?php

namespace app\admin\model;

use think\Model;

class Dapa extends Model
{
    protected $autoWriteTimestamp = true;
    // 关闭自动写入update_time字段
    protected $updateTime = false;
    // 定义时间戳字段名
    protected $createTime = 'time';


    //获取所有的商品分类
    public function getCats(){
        $cats = $this->select();
        return $this->tree($cats);
    }
    /**
     * 重新排序
     * @param  array  $arr [要排序的数组]
     * @param  integer $pid [父id]
     * @return array     [排好序的数组]
     */

    public function tree($arr,$pid = 0,$level = 0){
        static $res = array();
        foreach ($arr as $v) {
            if ($v['pid'] == $pid) {
                //说明找到，先保存，然后递归查找
                $v['level'] = $level;
                $res[] = $v;
                $this->tree($arr,$v['id'],$level+1);
            }
        }
        return $res;
    }




    /**
     * 获取指定分类所有的后代分类id，包括它自己
     * @param  int $cat_id [分类id]
     * @return array       [所有后代分类id]
     */
    public function getSubIds($id){
        $cats = $this->select();
        $cat= $this->tree($cats,$id); //二维数组
        $res = array();
        foreach ($cat as $v) {
            $res[] = $v['id'];
        }
        //将自己也追加到数组中
        $res[] = $id;
        return $res;
    }
}
