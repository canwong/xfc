<?php
namespace app\common\model;

use think\Model;

class Config extends Model
{
	public function lists(){
		$data   = $this->where('status',1)->field('type,name,value')->select();
		$config = [];
		if($data && is_array($data)){
			foreach ($data as $value) {
				$config[$value['name']] = $this->parse($value['type'], $value['value']);
			}
		}
		return $config;
	}

	/**
	 * 根据配置类型解析配置
	 * @param  integer $type  配置类型
	 * @param  string  $value 配置值
	 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
	 */
	private function parse($type, $value){
		switch ($type) {
			case 'textarea': //解析数组
			$array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
			if(strpos($value,':')){
				$value  = array();
				foreach ($array as $val) {
					$list = explode(':', $val);
					if(isset($list[2])){
						$value[$list[0]]   = $list[1].','.$list[2];
					}else{
						$value[$list[0]]   = $list[1];
					}
				}
			}else{
				$value =    $array;
			}
			break;
		}
		return $value;
	}

	protected function getTypeTextAttr($value,$data)
	{
		$type = config('config_type_list');
		$type_text = explode(',', $type[$data['type']]);
		return $type_text[0];
	}

}