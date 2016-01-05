<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 陈强  
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台班级管理控制器
 * @author 陈强 
 */
class ClassController extends AdminController {

    /**
     * 班级管理列表
     * @author 陈强 
     */
    public function index(){
        $tree = D('Class')->getTree(0,'id,name,title,sort,pid,allow_publish,status,college');
        //p($tree);die;
        $this->assign('tree', $tree);
        C('_SYS_GET_CLASS_TREE_', true); //标记系统获取班级树模板
        $this->meta_title = '班级管理';
        $this->display();
    }

    /**
     * 显示班级树，仅支持内部调
     * @param  array $tree 班级树
     * @author 陈强 
     */
    public function tree($tree = null){
        C('_SYS_GET_CLASS_TREE_') || $this->_empty();
        //P($tree);die;
        $this->assign('tree', $tree);
        $this->display('tree');
    }

    /* 编辑班级 */
    public function edit($id = null, $pid = 0){
        $Class = D('Class');

        if(IS_POST){ //提交表单
            if(false !== $Class->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Class->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = '';
            if($pid){
                /* 获取上级班级信息 */
                $cate = $Class->info($pid, 'id,name,title,status');
                if(!($cate && 1 == $cate['status'])){
                    $this->error('指定的上级班级不存在或被禁用！');
                }
            }

            /* 获取班级信息 */
            $info = $id ? $Class->info($id) : '';
            //p($info);die;
            $this->assign('info',       $info);
            $this->assign('class',   $cate);
            $this->meta_title = '编辑班级';
            $this->display();
        }
    }

    /* 新增班级 */
    public function add($pid = 0){
        $Class = D('Class');

        if(IS_POST){ //提交表单
            if(false !== $Class->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Class->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
            $cate = array();
            if($pid){
                /* 获取上级班级信息 */
                $cate = $Class->info($pid, 'id,name,title,status,college');
                if(!($cate && 1 == $cate['status'])){
                    $this->error('指定的上级班级不存在或被禁用！');
                }
            }
            //p($cate);die;
            /* 获取班级信息 */
            $this->assign('info',       null);
            $this->assign('class', $cate);
            $this->meta_title = '新增班级';
            $this->display('edit');
        }
    }

    /**
     * 删除一个班级
     * @author huajie <banhuajie@163.com>
     */
    public function remove(){
        $cate_id = I('id');
        if(empty($cate_id)){
            $this->error('参数错误!');
        }

        //判断该班级下有没有子班级，有则不允许删除
        $child = M('Class')->where(array('pid'=>$cate_id))->field('id')->select();
        if(!empty($child)){
            $this->error('请先删除该班级下的子班级');
        }

        //判断该班级下有没有内容
        $document_list = M('Document')->where(array('class_id'=>$cate_id))->field('id')->select();
        if(!empty($document_list)){
            $this->error('请先删除该班级下的文章（包含回收站）');
        }

        //删除该班级信息
        $res = M('Class')->delete($cate_id);
        if($res !== false){
            //记录行为
            action_log('update_class', 'class', $cate_id, UID);
            $this->success('删除班级成功！');
        }else{
            $this->error('删除班级失败！');
        }
    }

    /**
     * 操作班级初始化
     * @param string $type
     * @author huajie <banhuajie@163.com>
     */
    public function operate($type = 'move'){
        //检查操作参数
        if(strcmp($type, 'move') == 0){
            $operate = '移动';
        }else{
            $this->error('参数错误！');
        }
        $from = intval(I('get.from'));
        empty($from) && $this->error('参数错误！');

        //获取班级
        $map = array('status'=>1, 'id'=>array('neq', $from));
        $list = M('Class')->where($map)->field('id,pid,title,college')->select();


        //移动班级时增加移至根班级
        if(strcmp($type, 'move') == 0){
        	//不允许移动至其子孙班级
        	$list = tree_to_list(list_to_tree($list));

        	$pid = M('Class')->getFieldById($from, 'pid');
        	$pid && array_unshift($list, array('id'=>0,'title'=>'根班级'));
        }
        //p($list);die;
        $this->assign('type', $type);
        $this->assign('operate', $operate);
        $this->assign('from', $from);
        $this->assign('list', $list);
        $this->meta_title = $operate.'班级';
        $this->display();
    }

    /**
     * 移动班级
     * @author huajie <banhuajie@163.com>
     */
    public function move(){
        $to = I('post.to');
        $from = I('post.from');
        $res = M('Class')->where(array('id'=>$from))->setField('pid', $to);
        if($res !== false){
            $this->success('班级移动成功！', U('index'));
        }else{
            $this->error('班级移动失败！');
        }
    }
}
