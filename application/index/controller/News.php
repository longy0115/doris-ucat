<?php
namespace app\index\controller;

class News
{
    public function read()
    {
      $data = ['name'=>'thinkphp','url'=>'thinkphp.cn'];
      return json(['data'=>$data,'code'=>1,'message'=>'操作完成']);
    }
}
