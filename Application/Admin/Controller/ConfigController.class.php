<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

/**
 * 后台配置控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class ConfigController extends AdminController {

    /**
     * 配置管理
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        /* 查询条件初始化 */
        $map = array();
        $map  = array('status' => 1);
        if(isset($_GET['group'])){
            $map['group']   =   I('group',0);
        }
        if(isset($_GET['name'])){
            $map['name']    =   array('like', '%'.(string)I('name').'%');
        }

        $list = $this->lists('Config', $map,'sort,id');

        //p($list);die;
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->assign('group',C('CONFIG_GROUP_LIST'));
        $this->assign('group_id',I('get.group',0));
        $this->assign('list', $list);
        $this->meta_title = '配置管理';
        $this->display();
    }

    /**
     * 新增配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function add(){
        if(IS_POST){
            $Config = D('Config');
            $data = $Config->create();
            if($data){
                if($Config->add()){
                    S('DB_CONFIG_DATA',null);
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $this->meta_title = '新增配置';
            $this->assign('info',null);
            $this->display('edit');
        }
    }

    /**
     * 编辑配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function edit($id = 0){
        if(IS_POST){
            $Config = D('Config');
            $data = $Config->create();
            if($data){
                if($Config->save()){
                    S('DB_CONFIG_DATA',null);
                    //记录行为
                    action_log('update_config','config',$data['id'],UID);
                    $this->success('更新成功', Cookie('__forward__'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Config')->field(true)->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑配置';
            $this->display();
        }
    }

    /**
     * 批量保存配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function save($config){
        if($config && is_array($config)){
            $Config = M('Config');
            foreach ($config as $name => $value) {
                $map = array('name' => $name);
                $Config->where($map)->setField('value', $value);
            }
        }
        S('DB_CONFIG_DATA',null);
        $this->success('保存成功！');
    }

    /**
     * 删除配置
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('Config')->where($map)->delete()){
            S('DB_CONFIG_DATA',null);
            //记录行为
            action_log('update_config','config',$id,UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    // 获取某个标签的配置参数
    public function group() {
        $id     =   I('get.id',1);
        $type   =   C('CONFIG_GROUP_LIST');
        $list   =   M("Config")->where(array('status'=>1,'group'=>$id))->field('id,name,title,extra,value,remark,type')->order('sort')->select();
        if($list) {
            $this->assign('list',$list);
        }
        //p($list);die;
        $this->assign('id',$id);
        $this->meta_title = $type[$id].'设置';
        $this->display();
    }

    /**
     * 配置排序
     * @author huajie <banhuajie@163.com>
     */
    public function sort(){
        if(IS_GET){
            $ids = I('get.ids');

            //获取排序的数据
            $map = array('status'=>array('gt',-1));
            if(!empty($ids)){
                $map['id'] = array('in',$ids);
            }elseif(I('group')){
                $map['group']	=	I('group');
            }
            $list = M('Config')->where($map)->field('id,title')->order('sort asc,id asc')->select();

            $this->assign('list', $list);
            $this->meta_title = '配置排序';
            $this->display();
        }elseif (IS_POST){
            $ids = I('post.ids');
            $ids = explode(',', $ids);
            foreach ($ids as $key=>$value){
                $res = M('Config')->where(array('id'=>$value))->setField('sort', $key+1);
            }
            if($res !== false){
                $this->success('排序成功！',Cookie('__forward__'));
            }else{
                $this->error('排序失败！');
            }
        }else{
            $this->error('非法请求！');
        }
    }

    /**
     * 代码管理
     * @author 陈强 
     */
    public function code(){
        $map = array();
        if(isset($_GET['lx'])){
            $map['lx']   =   I('lx',0);
        }
        if(isset($_GET['mc'])){
            $map['mc']    =   array('like', '%'.(string)I('mc').'%');
        }
        //$list = $this->lists('TabCode');
        $total = D('CodeView')->where($map)->count();
        $nowPage = isset($_GET['p'])?$_GET['p']:1;
        $page = new \Think\Page($total,20);//, $listRows, $REQUEST
        if($total>$listRows){
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $list = D('CodeView')->where($map)->page($nowPage.','.$Page->listRows)->select();
        $p =$page->show();
        $this->assign('page', $p? $p: '');
        // 记录当前列表页的cookie
        //Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('list', $list);
        $this->meta_title = '代码管理';
        $this->display();
    }
    /**
     * 新增代码
     * @author 陈强 
     */
    public function addCode(){
        if(IS_POST){
            $Code = D('TabCode');
            $data = $Code->create();
            if($data){
                if($Code->add()){
                    action_log('add_code','tab_code',is_login());
                    $this->success('新增代码成功', U('code'));
                } else {
                    $this->error('新增代码失败');
                }
            } else {
                $this->error($Code->getError());
            }
        } else {
            $this->meta_title = '新增代码';
            $this->assign('info',null);
            $this->display('editCode');
        }
    }
    /**
     * 编辑代码
     * @author 陈强
     */
    public function editCode($id = 0){
        if(IS_POST){
            $Config = D('TabCode');
            $data = $Config->create();
            if($data){
                if($Config->save()){
                    //记录行为
                    //action_log('update_config','config',$data['id'],UID);
                    action_log('edit_code','tab_code',is_login());
                    $this->success('更新代码成功', Cookie('__forward__'));
                } else {
                    $this->error('更新代码失败');
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('TabCode')->field(true)->find($id);

            if(false === $info){
                $this->error('获取代码信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑代码';
            $this->display();
        }
    }
    /**
     * 删除代码
     * @author 陈强
     */
    public function delCode(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('TabCode')->where($map)->delete()){
            //S('DB_CONFIG_DATA',null);
            //记录行为
            //action_log('update_config','config',$id,UID);
            action_log('del_code','tab_code',is_login());
            $this->success('删除代码成功');
        } else {
            $this->error('删除代码失败！');
        }
    }
    // /**
    //  * 清空缓存
    //  * @author 陈强
    //  */
    // public function delCache(){
    //     import('ORG.Io.Dir');
    //     $a = Dir::delDir(TEMP_PATH);
    //     echo $a;die;
    // }

}