<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
	protected $rule = [
		'username|用户名' => 'require',
		'password|密码'  => 'require',
		'vcode|验证码' => 'require|captcha',
	];
}