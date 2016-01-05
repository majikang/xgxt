<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace User\Model;
use Think\Model;
/**
 * 会员模型
 */
class UcenterMemberModel extends Model{
	/**
	 * 数据表前缀
	 * @var string
	 */
	protected $tablePrefix = UC_TABLE_PREFIX;

	/**
	 * 数据库连接
	 * @var string
	 */
	protected $connection = UC_DB_DSN;

	/* 用户模型自动验证 */
	protected $_validate = array(
		/* 验证用户名 */
		array('username', '1,30', -1, self::EXISTS_VALIDATE, 'length'), //用户名长度不合法
		array('username', 'checkDenyMember', -2, self::EXISTS_VALIDATE, 'callback'), //用户名禁止注册
		array('username', '', -3, self::EXISTS_VALIDATE, 'unique'), //用户名被占用

		/* 验证密码 */
		array('password', '6,30', -4, self::EXISTS_VALIDATE, 'length'), //密码长度不合法

		/* 验证邮箱 */
		array('email', 'email', -5, self::EXISTS_VALIDATE), //邮箱格式不正确
		array('email', '1,32', -6, self::EXISTS_VALIDATE, 'length'), //邮箱长度不合法
		array('email', 'checkDenyEmail', -7, self::EXISTS_VALIDATE, 'callback'), //邮箱禁止注册
		array('email', '', -8, self::EXISTS_VALIDATE, 'unique'), //邮箱被占用

		/* 验证手机号码 */
		array('mobile', '//', -9, self::EXISTS_VALIDATE), //手机格式不正确 TODO:
		array('mobile', 'checkDenyMobile', -10, self::EXISTS_VALIDATE, 'callback'), //手机禁止注册
		array('mobile', '', -11, self::EXISTS_VALIDATE, 'unique'), //手机号被占用

		/* 验证校园卡号 */
		array('card', 'require', '校园卡号必填'),
        array('card', '/^[0-9]+$/', '校园卡号必须为数字','regex'),
        array('card', '', '校园卡号已被使用', self::EXISTS_VALIDATE, 'unique'),

	);

	/* 用户模型自动完成 */
	protected $_auto = array(
		array('password', 'think_ucenter_md5', self::MODEL_BOTH, 'function', UC_AUTH_KEY),
		array('reg_time', NOW_TIME, self::MODEL_INSERT),
		array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
		array('update_time', NOW_TIME),
		array('status', 'getStatus', self::MODEL_BOTH, 'callback'),
	);

	/**
	 * 检测用户名是不是被禁止注册
	 * @param  string $username 用户名
	 * @return boolean          ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMember($username){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 检测邮箱是不是被禁止注册
	 * @param  string $email 邮箱
	 * @return boolean       ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyEmail($email){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 检测手机是不是被禁止注册
	 * @param  string $mobile 手机
	 * @return boolean        ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMobile($mobile){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 根据配置指定用户状态
	 * @return integer 用户状态
	 */
	protected function getStatus(){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 注册一个新用户（不允许，只能后台添加）
	 * @param  string $username 用户名
	 * @param  string $password 密码
	 * @param  string $card 职工卡号或学生卡号
	 * @param  string $email 邮箱
	 * @param  string $mobile 手机号码
	 * @return integer          注册成功-用户信息，注册失败-错误编号
	 */
	public function register($name, $password, $card, $email, $mobile){
		$data = array(
			'username' => $name,
			'password' => $password,
			'card'	   => $card,
			'email'    => $email,
			'mobile'   => $mobile,
		);

		//验证手机
		if(empty($data['mobile'])) unset($data['mobile']);
		//验证手机
		if(empty($data['email'])) unset($data['email']);

		/* 添加用户 */
		if($this->create($data)){
			$uid = $this->add();
			return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
	}

	/**
	 * 用户登录认证
	 * @param  string  $username 用户名
	 * @param  string  $password 用户密码
	 * @param  integer $type     用户名类型 （1-用户名，2-职工卡号OR学生卡号，3-UID）(自判断)
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function login($username, $password){
		$map = array();
		//如果使用校园卡号登陆，则判断是老师或学生（学生只允许使用校园卡号登陆，老师可以校园卡号或用户名）
		if(is_numeric($username)){
			//先判断是否是后台用户
			$map['card'] = $username;
			$result = $this->get_user_info($map,$password);
			if($result['id']>0)
				return $result;
			//学生基本信息列表中，校园卡号字段名 @uid
			unset($map);
			$map = "uid = ".$username;
			$result = $this->get_student_info($map,$password);
			if($result['id']>0)
				return $result;
			unset($map);
			$map = "userid = ".$username;
			$result = $this->get_contact_info($map,$password);
			if($result['id']>0)
				return $result;
		}elseif (!is_null($username)) {
			unset($map);$map = array();

			$map['username'] = $username;
			$result = $this->get_user_info($map,$password);

			if($result['id']>0)
				return $result;
			else
				return -12;//密码或账号错误
		}
	}

	/**
	 * 获取用户信息
	 * @param  string  $uid         用户ID或用户名
	 * @param  boolean $is_username 是否使用用户名查询
	 * @return array                用户信息
	 */
	public function info($uid, $is_username = false){
		$map = array();
		if($is_username){ //通过用户名获取
			$map['username'] = $uid;
		} else {
			$map['id'] = $uid;
		}

		$user = $this->where($map)->field('id,username,email,mobile,status')->find();
		if(is_array($user) && $user['status'] = 1){
			return array($user['id'], $user['username'], $user['email'], $user['mobile']);
		} else {
			return -1; //用户不存在或被禁用
		}
	}

	/**
	 * 检测用户信息
	 * @param  string  $field  用户名
	 * @param  integer $type   用户名类型 1-用户名，2-用户邮箱，3-用户电话
	 * @return integer         错误编号
	 */
	public function checkField($field, $type = 1){
		$data = array();
		switch ($type) {
			case 1:
				$data['username'] = $field;
				break;
			case 2:
				$data['email'] = $field;
				break;
			case 3:
				$data['mobile'] = $field;
				break;
			default:
				return 0; //参数错误
		}

		return $this->create($data) ? 1 : $this->getError();
	}

	/**
	 * 更新用户登录信息
	 * @param  integer $uid 用户ID
	 */
	protected function updateLogin($uid){
		$data = array(
			'id'              => $uid,
			'last_login_time' => NOW_TIME,
			'last_login_ip'   => get_client_ip(1),
		);
		$this->save($data);
	}

	/**
	 * 更新用户信息
	 * @param int $uid 用户id
	 * @param string $password 密码，用来验证
	 * @param array $data 修改的字段数组
	 * @return true 修改成功，false 修改失败
	 * @author huajie <banhuajie@163.com>
	 */
	public function updateUserFields($uid, $datas){
		if(empty($uid) || empty($datas)){
			$this->error = '参数错误！';
			return false;
		}

		// //更新前检查用户密码
		// if(!$this->verifyUser($uid, $password)){
		// 	$this->error = '验证出错：密码不正确！';
		// 	return false;
		// }

		//更新用户信息
		$data['depart'] = $datas['depart_id'];
		$data['username'] = $datas['name'];
		$data = $this->create($data);
		if($data){
			return $this->where(array('id'=>$uid))->save($data);
		}
		return false;
	}

	/**
	 * 验证用户密码
	 * @param int $uid 用户id
	 * @param string $password_in 密码
	 * @return true 验证成功，false 验证失败
	 * @author huajie <banhuajie@163.com>
	 */
	protected function verifyUser($uid, $password_in){
		$password = $this->getFieldById($uid, 'password');
		if(think_ucenter_md5($password_in, UC_AUTH_KEY) === $password){
			return true;
		}
		return false;
	}
	/**
	 * 登陆时获取后台用户信息
	 * @param array $map 查询的条件
	 * @param string $password 密码，用来验证
	 * @return true 修改成功，false 修改失败
	 * @author 陈强
	 */
	protected function get_user_info($map, $password){
		//可以根据传进来的$map，来判断后台用户使用的是 校园卡号还是姓名
		$user = $this->where($map)->find();
		if(is_array($user) && $user['status']){
			/* 验证用户密码 */
			if(think_ucenter_md5($password, UC_AUTH_KEY) === $user['password']){
				$this->updateLogin($user['id']); //更新用户登录信息
				return array('uid'=>$user['card'],'type'=>1, 'id'=>$user['id']); //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}
	/**
	 * 登陆时获取学生信息
	 * @param array $map 查询的条件
	 * @param string $password 密码，用来验证
	 * @return true 修改成功，false 修改失败
	 * @author 陈强
	 */
	protected function get_student_info($map, $password){
		$user = M('Stu')->where($map)->find();
		if(is_array($user)){
			/* 验证用户密码 */
			if(think_ucenter_md5($password, UC_AUTH_KEY) == $user['mm']){
				return array('uid'=>$user['uid'], 'type'=>2, 'id'=>$user['id']); //登录成功，返回学生用户ID2
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}
	/**
	 * 登陆时获取辅导员信息
	 * @param array $map 查询的条件
	 * @param string $password 密码，用来验证
	 * @return true 修改成功，false 修改失败
	 * @author 陈强
	 */
	protected function get_contact_info($map, $password){
		//可以根据传进来的$map，来判断后台用户使用的是 校园卡号还是姓名
		$user = $this->where($map)->find();
		if(is_array($user) && $user['status']){
			/* 验证用户密码 */
			if($password == 'nopassword'){
				$this->updateLogin($user['id']); //更新用户登录信息
				return array('uid'=>$user['userid'],'type'=>3,'id'=>$user['id']); //登录成功，返回用户ID
			}
			if(think_ucenter_md5($password, UC_AUTH_KEY) === $user['password']){

				$this->updateLogin($user['id']); //更新用户登录信息
				return array('uid'=>$user['userid'],'type'=>3,'id'=>$user['id']); //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}

}
