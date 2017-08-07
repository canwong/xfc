<?php
namespace app\admin\controller;

use app\common\controller\Adminbase;
use app\common\model\Model as ModelMod;

class Model extends Adminbase
{
	protected function _initialize()
	{
		parent::_initialize();
		$this->setContentMenu();
	}

	public function index()
	{
		$list = ModelMod::field(true)->select();
		$this->assign('list',$list);
		$this->assign('mete_title','模型管理');
		return $this->fetch();
	}
	
}