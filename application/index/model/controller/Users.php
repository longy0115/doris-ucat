<?php
namespace app\index\controller;
use app\index\model\Users as MUsers;
class Users {
  //登陆
  public function login () {
    $MUsers = new MUsers;
    $result = $MUsers->login();
    return json($result);
  }
  //注册
  public function register () {
    $MUsers = new MUsers;
    $result = $MUsers->register;
    if ($result) {
      return json(['Data'=>$result,'Code'=>1,'Message'=>'']);
    } else {
      dump($result);
      return json(['Code'=>0,'Message'=>'注册失败:']);
    }
  }
}