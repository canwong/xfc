<?php
namespace app\common\model;

class Model extends \think\Model
{
	protected function getCreateTimeAttr($v)
	{
		return date('Y-m-d H:m',$v);
	}
}