<?php
namespace app\admin\controller;

use think\Request;
use app\common\controller\Adminbase;
use app\common\model\Channel as ChannelMod;

class Channel extends Adminbase
{
	public function index()
	{
		$list = ChannelMod::all();
		$this->assign('list',$list);
		$this->assign('mete_title','导航管理');
		return $this->fetch();
	}
}