<?php
namespace app\index\controller;

use app\index\model\Users;

class Index
{
    public function index()
    {
        $id=input('id');
        session('api-id',$id);
        halt($id);
    }

    public function test(){
        $m=new Users();
        $m->login();
        halt(111);
    }
}
