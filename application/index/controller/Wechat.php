<?php

namespace app\index\controller;

use service\WechatService;
use EasyWeChat\Factory;
/**
 * 微信服务器  验证控制器
 * Class Wechat
 */

class Wechat 
{
    public function index()
    {
        halt('wechat');
    }

    //weixin
    public function checkToken()
    {
        $config=config('wechat_config');
        $app = Factory::officialAccount($config);

        $app->server->push(function ($message) {
            return "您好！欢迎使用 EasyWeChat!";
        });

        $response = $app->server->serve();

        // 将响应输出
        $response->send();
       
    }

    /**
     * 微信服务器  验证
     */
    public function valid(){
        $echoStr = input("echostr");
        cache('echoStr', $echoStr);
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    /**
     * 用于验证是否是微信服务器发来的消息
     * @return bool
     */
    private function checkSignature()
    {
        $signature = input("signature");
        $timestamp = input("timestamp");
        $nonce = input("nonce");
        
        $token = config('wx_info_test.token');
        $tmpArr =array($timestamp, $nonce, $token);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}
