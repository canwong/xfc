<?php
namespace app\common\controller;

use think\Controller;
use think\Request;
use think\Session;
use app\common\model\Menu;
use app\common\model\Model as ModelMod;

class Adminbase extends Base
{
	protected function _initialize()
	{
		parent::_initialize();
		//检测是否登录
		$request = Request::instance();
		if (!Session::has('user_auth_sign') && $request->action() !== 'login') {
			$this->redirect('admin/index/login');
		}

		//生成导航
		$this->setmenu();
	}

	protected function setmenu()
	{
		$request = Request::instance();
		$menuMod = new Menu;
		//取得当前网址模块+控制器(相当于顶级菜单)
		$hover_url = $request->module().DS.$request->controller();
		//当前网址模块+控制器+行为
		$current = $request->module().DS.$request->controller().DS.$request->action();
		//构建二维菜单数组
		$navmenu = ['main'=>[],'child'=>[]];
		//取出一级菜单
		$row = $menuMod->field('id,title,url,icon,"" as style')
					   ->where('pid',0)
					   ->where('hide',0)
					   ->where('type','admin')
					   ->select();
		//构建主导航菜单
		foreach ($row as $k => $v) {
			$navmenu['main'][$v['id']] = $v;
		}
		//查找子菜单
		$pid = $menuMod->where('pid','neq',0)
					   ->where('url','like',"%{$hover_url}%")
					   ->value('pid');
		if ($pid) {
			$row = $menuMod->field('id,title,url,icon,group,pid,"" as style')
						   ->where('pid',$pid)
						   ->where('hide',0)
						   ->where('type','admin')
						   ->select();
			foreach ($row as $k => $v) {
				if ($current == $v['url']) {
					$menu['main'][$v['pid']]['style'] = "active";
					$v['style']                   = "active";
				}
				$navmenu['child'][$v['group']][] = $v;
			}
		}
		//构建面包屑导航
		$breadcrumb = [];
		if ('index'!==$request->action()) {
			$lasturl = $hover_url.DS.'index';
			$breadcrumb[] = $menuMod->where('url',$lasturl)->field('id,title,url,"" as style')->find();
		}
		$breadcrumb[] = $menuMod->where('url',$current)->field('id,title,url,"active" as style')->find();
		$this->assign('breadcrumb',$breadcrumb);
		$this->assign('navmenu',$navmenu);
	}

	protected function setContentMenu()
	{
		$list = ModelMod::where('status','>',0)->where('extend','>',0)->field("name,id,title,icon,'' as 'style'")->select();
		$this->assign('extend_title','内容管理');
		$this->assign('extend_menu',$list);
	}
}