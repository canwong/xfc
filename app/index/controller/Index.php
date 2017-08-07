<?php
namespace app\index\controller;

use app\common\controller\Frontbase;

class Index extends Frontbase
{
    public function index()
    {
        return $this->fetch();
    }
}
