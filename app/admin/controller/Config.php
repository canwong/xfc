<?php
namespace app\admin\controller;

use think\Request;
use think\Config as Conf;
use app\common\controller\Adminbase;
use app\common\model\Config as ConfigMod;

class Config extends Adminbase
{
	public function index()
	{
		$configmod = new ConfigMod;
		$request = Request::instance();
		$group_id = $request->param('group');
		$where = ['status'=>1];
		if ($group_id) {
			$where['group'] = $group_id;
		}
		$list = $configmod->field(true)->where($where)->order('id desc')->paginate(25);
		$this->assign('group',config('config_group_list'));
		$this->assign('group_id',$group_id);
		$this->assign('list',$list);
		$this->assign('page',$list->render());
		$this->assign('mete_title','网站设置');
		return $this->fetch();
	}

	public function group($id = 1)
	{
		$request = Request::instance();
		$configMod = new ConfigMod;
		if ($request->isPost()) {
			$params = $request->param('config/a');
			foreach ($params as $k => $v) {
				$configMod->where('name',$k)->setField('value',$v);
			}
			cache('db_config_data',null);
			$this->success('Update Success!');
		}
		else {
			$type = config('config_group_list');
			$list = $configMod->where(['status' => 1, 'group' => $id])->field('id,name,title,extra,value,remark,type')->order('sort')->select();
			if ($list) {
				$this->assign('list', $list);
			}
			$this->assign('group',$type);
			$this->assign('id', $id);
			$this->assign('mete_title','配置管理');
			return $this->fetch();
		}
	}
}