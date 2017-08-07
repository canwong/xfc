<?php
namespace app\common\model;

use think\Model;

class Menu extends Model
{
	protected function getHideAttr($v)
	{
		$change = [
			0 => '否',
			1 => '是'
		];
		return $change[$v];
	}

	protected function getIsDevAttr($v)
	{
		$change = [
			0 => '否',
			1 => '是'
		];
		return $change[$v];
	}

}