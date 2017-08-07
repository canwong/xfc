<?php
namespace app\admin\controller;

use think\Request;
use app\common\controller\Adminbase;
use app\common\model\User;

class Index extends Adminbase
{
	public function index()
	{
		return $this->fetch();
	}
	
	//返回登录页面
	public function login($username='',$password='',$vcode='')
	{
		$request = Request::instance();
		//判断表单提交方式
		if ($request->isPost()) {
			$params = $request->param();
			//验证数据格式
			$resault = $this->validate($params,'User');
			if (true !== $resault) {
				$callback = $resault;
			}
			else {
				//验证数据库账号密码
				$user = new User;
				$uid = $user->login($params['username'],$params['password']);
				if ($uid > 0) {
					$this->success('登录成功',url('admin/index/index'));
				}
				switch ($uid) {
					case '-1':
						$callback = '用户名不存在';
						break;
					case '-2':
						$callback = '密码错误';
						break;
					default:
						$callback = '未知错误!';
						break;
				}
			}
			$this->error($callback);
		}
		else {
			return $this -> fetch();
		}
	}
}