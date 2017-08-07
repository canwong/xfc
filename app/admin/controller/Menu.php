<?php
namespace app\admin\controller;

use app\common\controller\Adminbase;
use app\common\model\Menu as MenuMod;

class Menu extends Adminbase
{
	public function index()
	{
		$menumod = new MenuMod;
		$list = [];
		$where = ['type'=>'admin','hide'=>0,'status'=>0];
		$alllist = $menumod->where($where)
						   ->order('sort asc,id asc')
						   ->field(true)
						   ->select();
		foreach ($alllist as $arr) {
			$list[$arr['pid']][] = $arr;
		}
		$this->assign('list',$list);
		$this->assign('mete_title','菜单管理');
		return $this->fetch();
	}

}