<?php
namespace Admin\Model;
use Think\Model;

/**
 * 用户模型
 * @author 陈强
 */

class MemberModel extends Model {

    protected $_validate = array(
        array('card', 'require', '校园卡号必填'),
        array('card', '/^[0-9]+$/', '校园卡号必须为数字','regex'),
        array('card', '', '校园卡号已被使用', self::EXISTS_VALIDATE, 'unique'),
        array('name', 'require', '姓名必填'),
        array('name', '1,20', '姓名长度为1-20个字符', self::EXISTS_VALIDATE, 'length'),
        array('name', '', '姓名被占用', self::EXISTS_VALIDATE, 'unique'), //用户名被占用
        array('spell', 'require', '姓名拼音必填'),
        array('spell', '/^[a-z]+$/', '姓名拼音必须使用小写字母','regex'),
        array('depart_id', 'require', '所在部门必填'),

    );

    public function lists($status = 1, $order = 'uid DESC', $field = true){
        $map = array('status' => $status);
        return $this->field($field)->where($map)->order($order)->select();
    }

    /**
     * 登录指定用户
     * @param  integer $uid 用户ID
     * @return boolean      ture-登录成功，false-登录失败
     */
    public function login($uid){
        /* 检测是否在当前应用注册 */
        //判断登录的是后台用户还是前台用户（$uid 是数组  1.uid(学生则为卡号) 2.type {3.uids学生后台的uid}）
        if($uid['type'] == 1) $id = $uid['id'];
        if($uid['type'] == 2 || $uid['type'] == 3) $id = $uid['uids'];
        $map = array('uid'=>$id);
        $user = $this->where($map)->find();
        if(!$user || 1 != $user['status']) {
            $this->error = '用户不存在或已被禁用！'; //应用级别禁用
            return false;
        }

        //记录行为
        action_log('user_login', 'member', $id, $id);

        /* 登录用户 */
        $this->autoLogin($uid);
        return true;
    }

    /**
     * 注销当前用户
     * @return void
     */
    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        //后台用户登录
        if($user['type'] == 1){
            $map = "uid = ".$user['id'];
            $users = $this->where($map)->find();
            /* 更新登录信息 */
            $data = array(
                'uid'             => $users['uid'],
                'login'           => array('exp', '`login`+1'),
                'last_login_time' => NOW_TIME,
                'last_login_ip'   => get_client_ip(1),
            );

            $this->save($data);
            /* 记录登录SESSION和COOKIES */
            $auth = array(
                'uid'             => $users['uid'],
                'username'        => $users['name'],
                'last_login_time' => $users['last_login_time'],
                'uids'            => $users['card'],
                'type'            => 1,
            );
        //学生登录
        }elseif ($user['type'] == 2){
            $map = "uid = ".$user['uid'];
            $users = M('Stu')->where($map)->find();
            /* 记录登录SESSION和COOKIES */
            $auth = array(
                'uid'             => $user['uids'],
                'sid'             => $users['id'],
                'username'        => $users['title'],
                'uids'            => $users['uid'],
                'type'            => 2,
            );
        }elseif ($user['type'] == 3){
            $map = "userid = ".$user['uid'];
            $users = M('TabContact')->where($map)->find();
            /* 记录登录SESSION和COOKIES */
            $auth = array(
                'uid'             => $user['uids'],
                'cid'             => $users['id'],
                'username'        => $users['title'],
                'uids'            => $users['userid'],
                'type'            => 2,
            );
        }else{
            $this->error("未知错误！请联系管理员");
        }
        
        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));

    }

    public function getNickName($uid){
        return $this->where(array('uid'=>(int)$uid))->getField('name');
    }

}
