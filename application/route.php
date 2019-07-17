<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];
use think\Route;
// 注册路由到index模块的News控制器的read操作
Route::get('new','News/read'); // 定义GET请求路由规则

Route::get('/', 'Index/index'); //首页
Route::get('test', 'Index/test'); //test 

// 旅游
Route::get('travels','Actives/getTravels'); // 定义GET请求路由规则
Route::get('travel_detail/:id','Actives/getTravelDetail');
Route::get('my_travels','Actives/getMyTravels');

// 运动
Route::get('sports','Actives/getSports');
Route::get('sport_detail/:id','Actives/getSportDetail');
Route::get('my_sports','Actives/getMySports');

// 发布 旅游/运动
Route::post('post_active','Actives/postActive');
Route::get('post_active','Actives/postActive');
//登陆 注册
Route::post('login','Users/login');
Route::post('register','Users/register');

//微信公众号
Route::rule('wechat', 'wechat/Wechat/index');
Route::rule('reply', 'wechat/Wechat/reply'); //验证入口 
Route::rule('wechat/reply', 'wechat/Wechat/reply'); //验证入口
Route::get('wechat/getMenu', 'wechat/Wechat/getMenu'); //获取菜单delMenu
Route::get('wechat/delMenu', 'wechat/Wechat/delMenu'); //删除菜单
Route::get('wechat/addMenu', 'wechat/Wechat/addMenu'); //添加菜单
Route::get('wechat/sendTemp', 'wechat/Wechat/sendTemp'); //发送模版消息
Route::get('wechat/getJssdk', 'wechat/Wechat/getJssdk');//getJssdk



