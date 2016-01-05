<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 朱亚杰 <zhuyajie@topthink.net>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Admin\Model\AuthRuleModel;
use Admin\Model\AuthGroupModel;
use User\Common\common;
/**
 * 权限管理控制器
 * Class AuthManagerController
 * @author 朱亚杰 <zhuyajie@topthink.net>
 */
class AuthManagerController extends AdminController{

    /**
     * 后台节点配置的url作为规则存入auth_rule
     * 执行新节点的插入,已有节点的更新,无效规则的删除三项任务
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function updateRules(){
        //需要新增的节点必然位于$nodes
        $nodes    = $this->returnNodes(false);

        $AuthRule = M('AuthRule');
        $map      = array('module'=>'admin','type'=>array('in','1,2'));//status全部取出,以进行更新
        //需要更新和删除的节点必然位于$rules
        $rules    = $AuthRule->where($map)->order('name')->select();

        //构建insert数据
        $data     = array();//保存需要插入和更新的新节点
        foreach ($nodes as $value){
            $temp['name']   = $value['url'];
            $temp['title']  = $value['title'];
            $temp['module'] = 'admin';
            if($value['pid'] >0){
                $temp['type'] = AuthRuleModel::RULE_URL;
            }else{
                $temp['type'] = AuthRuleModel::RULE_MAIN;
            }
            $temp['status']   = 1;
            $data[strtolower($temp['name'].$temp['module'].$temp['type'])] = $temp;//去除重复项
        }

        $update = array();//保存需要更新的节点
        $ids    = array();//保存需要删除的节点的id
        foreach ($rules as $index=>$rule){
            $key = strtolower($rule['name'].$rule['module'].$rule['type']);
            if ( isset($data[$key]) ) {//如果数据库中的规则与配置的节点匹配,说明是需要更新的节点
                $data[$key]['id'] = $rule['id'];//为需要更新的节点补充id值
                $update[] = $data[$key];
                unset($data[$key]);
                unset($rules[$index]);
                unset($rule['condition']);
                $diff[$rule['id']]=$rule;
            }elseif($rule['status']==1){
                $ids[] = $rule['id'];
            }
        }
        if ( count($update) ) {
            foreach ($update as $k=>$row){
                if ( $row!=$diff[$row['id']] ) {
                    $AuthRule->where(array('id'=>$row['id']))->save($row);
                }
            }
        }
        if ( count($ids) ) {
            $AuthRule->where( array( 'id'=>array('IN',implode(',',$ids)) ) )->save(array('status'=>-1));
            //删除规则是否需要从每个用户组的访问授权表中移除该规则?
        }
        if( count($data) ){
            $AuthRule->addAll(array_values($data));
        }
        if ( $AuthRule->getDbError() ) {
            trace('['.__METHOD__.']:'.$AuthRule->getDbError());
            return false;
        }else{
            return true;
        }
    }


    /**
     * 权限管理首页
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function index(){
        $list = $this->lists('AuthGroup',array('module'=>'admin'),'id asc');
        $list = int_to_string($list);
        $this->assign( '_list', $list );
        $this->assign( '_use_tip', true );
        $this->meta_title = '权限管理';
        $this->display();
    }

    /**
     * 创建管理员用户组
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function createGroup(){
        if ( empty($this->auth_group) ) {
            $this->assign('auth_group',array('title'=>null,'id'=>null,'description'=>null,'rules'=>null,));//排除notice信息
        }
        $this->meta_title = '新增用户组';
        $this->display('editgroup');
    }

    /**
     * 编辑管理员用户组
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function editGroup(){
        $auth_group = M('AuthGroup')->where( array('module'=>'admin','type'=>AuthGroupModel::TYPE_ADMIN) )
                                    ->find( (int)$_GET['id'] );
        $this->assign('auth_group',$auth_group);
        $this->meta_title = '编辑用户组';
        $this->display();
    }


    /**
     * 访问授权页面
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function access(){
        $this->updateRules();
        $auth_group = M('AuthGroup')->where( array('status'=>array('egt','0'),'module'=>'admin','type'=>AuthGroupModel::TYPE_ADMIN) )
                                    ->getfield('id,id,title,rules');
        $node_list   = $this->returnNodes();
        $map         = array('module'=>'admin','type'=>AuthRuleModel::RULE_MAIN,'status'=>1);
        $main_rules  = M('AuthRule')->where($map)->getField('name,id');
        $map         = array('module'=>'admin','type'=>AuthRuleModel::RULE_URL,'status'=>1);
        $child_rules = M('AuthRule')->where($map)->getField('name,id');
        $this->assign('main_rules', $main_rules);
        $this->assign('auth_rules', $child_rules);
        $this->assign('node_list',  $node_list);
        $this->assign('auth_group', $auth_group);
        $this->assign('this_group', $auth_group[(int)$_GET['group_id']]);
        $this->meta_title = '访问授权';
        $this->display('managergroup');
    }

    /**
     * 管理员用户组数据写入/更新
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function writeGroup(){
        if(isset($_POST['rules'])){
            sort($_POST['rules']);
            $_POST['rules']  = implode( ',' , array_unique($_POST['rules']));
        }
        $_POST['module'] =  'admin';
        $_POST['type']   =  AuthGroupModel::TYPE_ADMIN;
        $AuthGroup       =  D('AuthGroup');
        $data = $AuthGroup->create();
        if ( $data ) {
            if ( empty($data['id']) ) {
                $r = $AuthGroup->add();
            }else{
                $r = $AuthGroup->save();
            }
            if($r===false){
                $this->error('操作失败'.$AuthGroup->getError());
            } else{
                $this->success('操作成功!',U('index'));
            }
        }else{
            $this->error('操作失败'.$AuthGroup->getError());
        }
    }

    /**
     * 状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        if ( empty($_REQUEST['id']) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbidgroup':
                $this->forbid('AuthGroup');
                break;
            case 'resumegroup':
                $this->resume('AuthGroup');
                break;
            case 'deletegroup':
                $this->delete('AuthGroup');
                break;
            default:
                $this->error($method.'参数非法');
        }
    }

    /**
     * 用户组授权用户列表
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function user($group_id){
        if(empty($group_id)){
            $this->error('参数错误');
        }

        $auth_group = M('AuthGroup')->where( array('status'=>array('egt','0'),'module'=>'admin','type'=>AuthGroupModel::TYPE_ADMIN) )->getfield('id,title,rules');
        $prefix   = C('DB_PREFIX');
        $l_table  = $prefix.(AuthGroupModel::MEMBER);
        $r_table  = $prefix.(AuthGroupModel::AUTH_GROUP_ACCESS);
        $model    = M()->table( $l_table.' m' )->join ( $r_table.' a ON m.uid=a.uid' );
        $_REQUEST = array();
        $list = $this->lists($model,array('a.group_id'=>$group_id,'m.status'=>array('egt',0)),'m.uid asc','m.uid,m.name,m.last_login_time,m.last_login_ip,m.status');
        int_to_string($list);
        $ouid    = M()->table($r_table)->field('uid')->select();
        if(!empty($ouid)){
            $tmparray = arrayChange($ouid);
            $outuid = implode(',',$tmparray);
            $map['uid'] = array('not in',$outuid);
            $map['status'] = 1;
            $list1    = M()->table($l_table)->field('uid,name')->where($map)->select();
            $this->assign( '_list1',     $list1 );
        }else{
            $tmparray = arrayChange($ouid);
            $outuid = implode(',',$tmparray);
            $map['status'] = 1;
            $list1    = M()->table($l_table)->field('uid,name')->where($map)->select();
            $this->assign( '_list1',     $list1 );
        }
        $this->assign( '_list',     $list );
        $this->assign('auth_group', $auth_group);
        $this->assign('this_group', $auth_group[(int)$_GET['group_id']]);
        $this->meta_title = '成员授权';
        $this->display();
    }

    /**
     * 将分类添加到用户组的编辑页面
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function category(){
        $auth_group     =   M('AuthGroup')->where( array('status'=>array('egt','0'),'module'=>'admin','type'=>AuthGroupModel::TYPE_ADMIN) )
            ->getfield('id,id,title,rules');
        $group_list     =   D('Class')->getTree();
        $authed_group   =   AuthGroupModel::getClassOfGroup(I('uid'));
        $this->assign('authed_group',   implode(',',(array)$authed_group));
        $this->assign('group_list',     $group_list);
        $this->assign('auth_group',     $auth_group);
        $this->assign('this_group',     $auth_group[(int)$_GET['group_id']]);
        $this->meta_title = '分类授权';
        $this->display();
    }

    public function tree($tree = null){
        $this->assign('tree', $tree);
        $this->display('AuthManager/tree');
    }

    /**
     * 将用户添加到用户组的编辑页面
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function group(){
        $uid            =   I('uid');
        $auth_groups    =   D('AuthGroup')->getGroups();
        $user_groups    =   AuthGroupModel::getUserGroup($uid);
        $ids = array();
        foreach ($user_groups as $value){
            $ids[]      =   $value['group_id'];
        }
        $isset = M('AuthGroupAccess')->where(array('uid'=>$uid))->find();
        if(!empty($isset)){
            $gid = $isset['group_id'];
            $this->assign('existence',1);
            $gname = D('AuthGroup')->where(array('id'=>$gid))->find();
            $this->name = $gname['title'];
        }
        $names       =   D('Member')->getNickName($uid);
        $this->assign('names',   $names);
        $this->assign('auth_groups',$auth_groups);
        $this->assign('user_groups',implode(',',$ids));
        $this->meta_title = '用户组授权';
        $this->display();
    }

    /**
     * 将用户添加到用户组,入参uid,group_id
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function addToGroup(){
        $uid = I('uid');
        $gid = I('group_id');
        if( empty($uid) ){
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        if(is_numeric($uid)){
            if ( is_administrator($uid) ) {
                $this->error('该用户为超级管理员');
            }
            if( !M('Member')->where(array('uid'=>$uid))->find() ){
                $this->error('用户不存在');
            }
        }

        if( $gid && !$AuthGroup->checkGroupId($gid)){
            $this->error($AuthGroup->error);
        }
        if ( $AuthGroup->addToGroup($uid,$gid) ){
            $this->success('操作成功');
        }else{
            $this->error($AuthGroup->getError());
        }
    }

    /**
     * 将用户从用户组中移除  入参:uid,group_id
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function removeFromGroup(){
        $uid = I('uid');
        $gid = I('group_id');
        if( $uid==UID ){
            $this->error('不允许解除自身授权');
        }
        if( empty($uid) || empty($gid) ){
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        if( !$AuthGroup->find($gid)){
            $this->error('用户组不存在');
        }
        if ( $AuthGroup->removeFromGroup($uid,$gid) ){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }

    /**
     * 将分类添加到用户组  入参:cid,uid
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function addToClass(){
        $cid = I('cid');
        $uid = I('uid');
        if( empty($uid) ){
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        $Member = D('Member');
        if(!$Member->find($uid)){
            $this->error('用户不存在');
        }
        if( $cid && !$AuthGroup->checkClassId($cid)){
            $this->error($AuthGroup->error);
        }
        if ( $AuthGroup->addToClass($uid,$cid) ){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }

    /**
     * 将模型添加到用户组  入参:mid,group_id
     * @author 朱亚杰 <xcoolcc@gmail.com>
     */
    public function addToModel(){
        $mid = I('id');
        $gid = I('get.group_id');
        if( empty($gid) ){
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        if( !$AuthGroup->find($gid)){
            $this->error('用户组不存在');
        }
        if( $mid && !$AuthGroup->checkModelId($mid)){
            $this->error($AuthGroup->error);
        }
        if ( $AuthGroup->addToModel($gid,$mid) ){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }
    /**
     * 将分类添加到用户组  入参:cid,uid
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function addToClassout(){
        $cid = I('cid');
        $uid = I('uid');
        if( empty($uid) ){
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        $Member = D('Member');
        if(!$Member->find($uid)){
            $this->error('用户不存在');
        }
        if( $cid && !$AuthGroup->checkClassId($cid)){
            $this->error($AuthGroup->error);
        }
        if ( $AuthGroup->addToClass($uid,$cid) ){}
        else{
            $this->error($AuthGroup->getError());
        }
    }

    /**
     * 将用户添加到用户组,入参uid,group_id
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function addToGroupout(){
        $uid = I('uid');
        $gid = I('group_id');
        if( empty($uid) ){
            $this->error('参数有误');
        }
        $AuthGroup = D('AuthGroup');
        if(is_numeric($uid)){
            if ( is_administrator($uid) ) {
                $this->error('该用户为超级管理员');
            }
            if( !M('Member')->where(array('uid'=>$uid))->find() ){
                $this->error('用户不存在');
            }
        }

        if( $gid && !$AuthGroup->checkGroupId($gid)){
            $this->error($AuthGroup->error);
        }
        if($gid != 0 ){
            if ( $AuthGroup->addToGroup($uid,$gid) ){}
            else{$this->error($AuthGroup->getError());
            }
        }
    }
    /**
     * 重置密码
     * @author 陈强
     */
    public function repassword(){
        if(IS_POST){
            is_administrator() ? : $this->error('修改权限不够！');//根据角色级别来判断，是否有权限修改
            $data['password'] = I('post.password');
            empty($data['password']) && $this->error('请输入新密码');
            $repassword = I('post.repassword');
            empty($repassword) && $this->error('请输入确认密码');
            if($data['password'] !== $repassword){
                    $this->error('您输入的新密码与确认密码不一致');
                }
                $data['password'] = $this->think_ucenter_md5($repassword, 'yFhU8xP?=6*5|-mZuLgw:J7EQ"(Y^Os!M)S@zvRk');
                if(M('UcenterMember')->where(array('id'=>I('id')))->save($data)){
                    $this->success('修改密码成功！',U('User/index'));
                }else{
                    $this->error('修改密码失败！(可能输入的新密码与原密码相同)');
            }
        }else{
            $this->user = M('UcenterMember')->where(array('id'=>I('uid')))->find();
            $this->display();
        }
    }
/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string 
 */
private function think_ucenter_md5($str, $key = 'ThinkUCenter'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}
}
