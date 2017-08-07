<?php
namespace app\admin\controller;

use app\common\controller\Adminbase;
use app\common\model\Category as CategoryMod;

class Category extends Adminbase
{
	public function _initialize()
	{
		parent::_initialize();
		$this->setContentMenu();
	}

	public function index()
	{
		$alllist = CategoryMod::all();
		foreach ($alllist as $arr) {
			$list[$arr['pid']][] = $arr;
		}

		$this->assign('list',$list);
		$this->assign('mete_title','栏目列表');
		return $this->fetch();
	}
}