<?php
namespace app\common\model;

use think\Model;
use think\Session;

class User extends Model
{
	protected $table = 'can_member';

	//登录模型
	public function login($username = '',$password = '')
	{
		//查找用户
		$user = $this->where('username',$username)->find();
		if (isset($user['status']) && $user['status']) {
			//验证密码
			if (md5($password.$user['salt']) == $user['password']) {
				//完成登录，更新Session
				$this->autoLogin($user);
				return $user['uid'];
			}
			else {
				return -2;
			}
		}
		else {
			return -1;
		}
	}

	//自动登录用户
	private function autoLogin($user)
	{
		//更新登录信息
		$update = [
			'uid'             => $user['uid'],
			'login'           => array('exp', '`login`+1'),
			'last_login_time' => time(),
			'last_login_ip'   => get_client_ip(1),
		];
		$this->where('uid',$update['uid'])->update($update);

		//更新登录Sessin，生成签名认证
		$data = [
			'uid' => $user['uid'],
			'username' => $user['username'],
			'last_login_time' => $user['last_login_time']
		];
		Session::set('user_auth',$data);
		Session::set('user_auth_sign',data_auth_sign($data));
	}

}