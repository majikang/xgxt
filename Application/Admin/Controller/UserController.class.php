<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class UserController extends AdminController {

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        $name       =   I('name');
        $map['status']  =   array('egt',0);
        if(is_numeric($name)){
            $map['card']=   array('like','%'.$_GET['name'].'%');
        }else{
            $map['name']    =   array('like', '%'.(string)$name.'%');
        }

        $list   = $this->lists('Member', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '用户信息';
        $this->display();
    }
    /**
     * 修改个人信息初始化
     * @author 陈强
     */

    public function updateInformation(){
        $uid = I('uid');
        if(empty($uid)) $uid = UID;
        $list = M('Member')->where('uid = '.$uid)->find();
        //p($list);die;
        $this->assign('list', $list);
        $this->meta_title = '修改个人信息';
        $this->assign('depart',get_department());
        $this->display('updateInformation');
    }

    /**
     * 修改昵称提交
     * @author 陈强
     */
    public function submitInformation(){
        $uid = I('uid');
        if(empty($uid)) $uid = UID;
        else $this->is_power($uid);
        $Member =   D('Member');
        $data   =   $Member->create();
        //p($data);die;
        if(!$data){
            $this->error($Member->getError());
        }else{
            $User   =   new UserApi;
            $uids    =   $User->updateInfo($uid, $data);
            if(0 < $uids){ //注册成功
                $res = $Member->where(array('uid'=>$uid))->save($data);
                if($res){
                    $user               =   session('user_auth');
                    $user['username']   =   $data['username'];
                    session('user_auth', $user);
                    session('user_auth_sign', data_auth_sign($user));
                    $this->success('修改信息成功！');
                }else{
                    $this->error('修改信息失败！');
                }
            }
        }

    }

    /**
     * 修改密码初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updatePassword(){
        $this->meta_title = '修改密码';
        $this->display('updatepassword');
    }

    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitPassword(){
        //获取参数
        $password   =   I('post.old');
        empty($password) && $this->error('请输入原密码');
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');

        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }

        $Api    =   new UserApi();
        $res    =   $Api->updateInfo(UID, $password, $data);
        if($res['status']){
            $this->success('修改密码成功！');
        }else{
            $this->error($res['info']);
        }
    }

    /**
     * 用户行为列表
     * @author huajie <banhuajie@163.com>
     */
    public function action(){
        //获取列表数据
        $Action =   M('Action')->where(array('status'=>array('gt',-1)));
        $list   =   $this->lists($Action);
        int_to_string($list);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $this->assign('_list', $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    /**
     * 新增行为
     * @author huajie <banhuajie@163.com>
     */
    public function addAction(){
        $this->meta_title = '新增行为';
        $this->assign('data',null);
        $this->display('editaction');
    }

    /**
     * 编辑行为
     * @author huajie <banhuajie@163.com>
     */
    public function editAction(){
        $id = I('get.id');
        empty($id) && $this->error('参数不能为空！');
        $data = M('Action')->field(true)->find($id);

        $this->assign('data',$data);
        $this->meta_title = '编辑行为';
        $this->display('editaction');
    }

    /**
     * 更新行为
     * @author huajie <banhuajie@163.com>
     */
    public function saveAction(){
        $res = D('Action')->update();
        if(!$res){
            $this->error(D('Action')->getError());
        }else{
            $this->success($res['id']?'更新成功！':'新增成功！', Cookie('__forward__'));
        }
    }

    /**
     * 会员状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $this->is_power(I('uid',0));//根据角色级别来判断，是否有权限
        $id = array_unique((array)I('uid',0));
        if( in_array(C('USER_ADMIuser_authNISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['uid'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('Member', $map );
                break;
            case 'resumeuser':
                $this->resume('Member', $map );
                break;
            case 'deleteuser':
                if(M('AuthExtend')->where($map)->delete())
                    $this->delete('Member', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }

    public function add(){
        if(IS_POST){
            /* 检测密码 */
            $name = I('name');
            $password = I('password');
            $repassword = I('repassword');
            $card = I('card');
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }
            /* 调用注册接口注册用户 */
        $Member = D('Member'); 
        if(!$Member->create()){
                $this->error($Member->getError());
            }else{
            $User   =   new UserApi;
            $uid    =   $User->register($name, $password, $card);
            if(0 < $uid){ //注册成功
                    $Member->status = 1;
                    if($id = $Member->add()){
                        $_POST['uid'] = $id;
                        $authmanager=A("AuthManager");
                        $authmanager->addToGroupout();
                        $authmanager->addToClassout();
                        $this->success('用户添加成功！',U('index'));
                    }else{
                        $this->error('用户添加失败！');
                    }
                }
             else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        }
        } else {
            $this->assign('depart',get_department());
            $this->meta_title = '新增用户';
            $this->display();
        }
    }
    /**
     * 修改用户信息
     * @author 陈强
     */
    public function update_user(){
        if(IS_POST){

        }else{
            $name       =   I('name');
            $map['status']  =   array('egt',0);
            $list   = $this->lists('Member', $map);
            int_to_string($list);
            $this->assign('_list', $list);
            $this->meta_title = "修改用户信息";
        }
    } 
    /**
     * 重置密码
     * @author 陈强
     */
    public function repassword(){
        if(IS_POST){  
            $this->is_power(I('uid',0));//根据角色级别来判断，是否有权限
            $data['password'] = I('post.password');
            empty($data['password']) && $this->error('请输入新密码');
            $repassword = I('post.repassword');
            empty($repassword) && $this->error('请输入确认密码');
            if($data['password'] !== $repassword){
                    $this->error('您输入的新密码与确认密码不一致');
                }
                $data['password'] = $this->think_ucenter_md5($repassword, 'yFhU8xP?=6*5|-mZuLgw:J7EQ"(Y^Os!M)S@zvRk');
                if(M('UcenterMember')->where(array('id'=>I('uid')))->save($data)){
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
     * 判断当前角色是否有权限修改用户信息
     * @param  integer $uid  修改用户的uid
     * @return string        错误信息
     */
    private function is_power($uid = 0){
        if(IS_ROOT) return 1;
        if(session('user_auth.type') == 2) $this->error('学生无权限修改！');
        //先记录登录用户的level
        $map = "uid = ".session('user_auth.uid');
        $result = M('AuthGroupAccess')->where($map)->find();
        $map = "id = ".$result['group_id']; 
        $result = M('AuthGroup')->where($map)->find();
        $current_level = $result['level'];
        $map = "uid = ".$uid;
        $result = M('AuthGroupAccess')->where($map)->find();
        $map = "id = ".$result['group_id']; 
        if($result = M('AuthGroup')->where($map)->find())
            $target_level = $result['level'];
        else
            $target_level = 404;
        //levle 1最大,4最小
        if($current_level>=$target_level)
            $this->error("您无权对该用户操作！");
        else
            return 1;       
    }
    /**
     * 系统非常规MD5加密方法
     * @param  string $str 要加密的字符串
     * @return string 
     */
    private function think_ucenter_md5($str, $key = 'ThinkUCenter'){
        return '' === $str ? '' : md5(sha1($str) . $key);
    }

    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '姓名长度必须在16个字符以内！'; break;
            case -2:  $error = '姓名被禁止注册！'; break;
            case -3:  $error = '姓名被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            case -12: $error = '账号或密码错误！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }
    

}