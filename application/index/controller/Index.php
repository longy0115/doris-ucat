<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        $id=input('id');
        session('api-id',$id);
        halt($id);
    }

    public function test(){
        $id=session('api-id');
        halt($id);
    }
}
