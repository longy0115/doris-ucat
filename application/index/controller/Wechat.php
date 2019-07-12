<?php

namespace app\index\controller;

class Wechat 
{
    public function index()
    {
        //var_dump(config('wx_info_test.token'));
        $tmp=cache('tmpArr');
        $token= cache('token');
        $signature=cache('signature');
        $tmpStr=cache('tmpStr');
        $echoStr = cache('echoStr');
        var_dump($tmp);
        var_dump($tmpStr);
        var_dump($signature);
        var_dump($echoStr);
        var_dump($token);
        halt('微信公众号');
    }

    //验证入口
    public function checkToken()
    {
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
        cache('tmpArr', $tmpArr);
        cache('token', $token);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        cache('signature', $signature);
        cache('tmpStr', $tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}
