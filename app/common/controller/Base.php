<?php
namespace app\common\controller;

use think\Controller;
use think\Cache;
use think\Config;
use app\common\model\Config as ConfigMod;

/**
* 
*/
class Base extends Controller
{
	protected function _initialize()
	{
		//读取数据库配置
		$config = Cache::get('db_config_data');
		if (!$config) {
			$configMod = new ConfigMod;
			$config = $configMod->lists();
			Cache::set('db_config_data', $config);
		}
		Config::set($config);

	}
}