<?php
// +----------------------------------------------------------------------
// | Author: 陈强
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台首页控制器
 * @author 陈强
 */
class PublicController extends \Think\Controller {

    /**
     * 后台用户登录
     * @author 陈强
     */
    public function login($username = null, $password = null, $verify = null){
        if(IS_POST){
            $this->login_background($username, $password);
        } else {
            if(is_login()){
                $this->redirect('Index/index');
            }else{
                $this->login_turn();
                /* 读取数据库中的配置 */
                $config	=	S('DB_CONFIG_DATA');
                if(!$config){
                    $config	=	D('Config')->lists();
                    S('DB_CONFIG_DATA',$config);
                }
                C($config); //添加配置
                
                $this->display();
            }
        }
    }

    /* 退出登录 */
    public function logout(){
        if(is_login()){
            D('Member')->logout();
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }
    /*从学工系统登录页面登录*/
    private function login_background($username = null, $password = null, $verify = null){
        /* 检测验证码 TODO: */
        // if(!check_verify($verify)){
        //     $this->error('验证码输入错误！');
        // }
        /* 调用UC登录接口登录 */
        $User = new UserApi;
        $uid = $User->login($username, $password);//@array $uid(uid,type) type=1=>后台用户,type=>2 学生
        if(0 < $uid['id']){ //UC登录成功
            $Member = D('Member');
            if($uid['type'] == 1){
                /* 登录后台用户 */
                if($Member->login($uid)){ //登录用户
                    //TODO:跳转到登录前页面
                    $this->success('登录成功！', U('Index/index'));    
                } else {
                    $this->error($Member->getError());
                }
            }elseif ($uid['type'] == 2) {
                /* 登录后台用户 */
                $uid['uids'] = 2;
                if($Member->login($uid)){ //登录用户
                    //TODO:跳转到登录前页面
                    $this->success('登录成功！', U('Student/index'));
                } else {
                    $this->error($Member->getError());
                }
            }
            elseif ($uid['type'] == 3) {
                    /* 登录后台用户 */
                    $uid['uids'] = 3;
                    if($Member->login($uid)){ //登录用户
                        //TODO:跳转到登录前页面
                        $this->success('登录成功！', U('Student/index'));
                    } else {
                        $this->error($Member->getError());
                    }
                }
        } else { //登录失败
            switch($uid['id']) {
                case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                case -2: $error = '密码错误！'; break;
                default: $error = '请检查校园卡号，密码！'; break; // 0-接口参数错误（调试阶段使用）
            }
            //p($uid);die;
            $this->error($error);
        }
    }
    /*从信息门户跳转登录*/
    private function login_turn(){
        if(!empty($_SEESION['user'])){
            $User = new UserApi;
            $uid = $User->login($_SEESION['user'], 'nopassword');//@array $uid(uid,type) type=1=>后台用户,type=>2 学生,type=3=>辅导员
            if(0 < $uid['id']){ //UC登录成功
                $Member = D('Member');
                if($uid['type'] == 1){
                    /* 登录后台用户 */
                    if($Member->login($uid)){ //登录用户
                        //TODO:跳转到登录前页面
                        $this->success('登录成功！', U('Index/index'));    
                    } else {
                        $this->error($Member->getError());
                    }
                }elseif ($uid['type'] == 2) {
                    /* 登录后台用户 */
                    $uid['uids'] = 2;
                    if($Member->login($uid)){ //登录用户
                        //TODO:跳转到登录前页面
                        $this->success('登录成功！', U('Student/index'));
                    } else {
                        $this->error($Member->getError());
                    }
                }
                elseif ($uid['type'] == 3) {
                    /* 登录后台用户 */
                    $uid['uids'] = 3;
                    if($Member->login($uid)){ //登录用户
                        //TODO:跳转到登录前页面
                        $this->success('登录成功！', U('Student/index'));
                    } else {
                        $this->error($Member->getError());
                    }
                }
            } else { //登录失败
                switch($uid['id']) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '请检查校园卡号，密码！'; break; // 0-接口参数错误（调试阶段使用）
                }
                //p($uid);die;
                $this->error($error);
            }
        }else{
            return 1;
        }
    }
}
