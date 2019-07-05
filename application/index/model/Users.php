<?php
namespace app\index\model;
use think\Model;
use think\Db;
use \think\Request;
class Users extends Model {
  //登陆
  public function login () {
    $request = Request::instance();
    $username = $request->param('username');
    $password = $request->param('password');
    $list = Db::table('users')->where('username', $username)->find();
    if ($list) {
      if ($list['password'] == $password) {
        $result = ['Data'=>$list,'Code'=>1,'Message'=>''];
        cache('name', $username);
        cache('id', $list['id']);
      } else {
        $result = ['Code'=>0,'Message'=>'用户名或密码错误'];
      }
    } else {
      $result = ['Code'=>-1,'Message'=>'用户名未注册'];
    }
    return $result;
  }
  // 注册
  public function register () {
  }
}