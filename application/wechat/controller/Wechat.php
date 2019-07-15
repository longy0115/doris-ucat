<?php

namespace app\wechat\controller;

use service\WechatService;
/**
 * 微信服务器  验证控制器
 * Class Wechat
 */

class Wechat 
{
    public function index()
    {

        halt('微信测试');
    }

    //weixin
    public function reply()
    {
        $echostr=input("echostr");
        if (isset($echostr)) {     //验证微信
            $this->valid();
        } else { //回复消息 其他操作
            halt(111111);
            WechatService::serve();
        }
    }

    /**
     * 微信服务器  验证
     */
    public function valid(){
        $echoStr = input("echostr");
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
